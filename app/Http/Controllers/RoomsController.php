<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Models\Bookings;
use App\Models\Guests;
use App\Models\Items;
use App\Models\Kas;
use App\Models\Transactions;
use App\Models\Pricelist;
use App\Models\Saldo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Rooms::simplePaginate(8);

        return view('rooms', [
            "rooms" => $rooms,
        ]);
    }

    public function roomsettings()
    {
        $saldo = Saldo::find(1);

        return view('room-settings', [
            "saldo" => $saldo,
        ]);
    }

    public function update_room_settings(Request $request)
    {
        $saldo = Saldo::find(1);

        $update_saldo = $request->validate([
            'room_rate' => 'required|numeric|min:0', // Bisa menerima angka desimal
            'tax' => 'required|numeric|min:0', // Jika tax harus bisa desimal, gunakan decimal:1,2
        ]);

        $saldo->room_rate = $update_saldo['room_rate'];
        $saldo->tax = $update_saldo['tax'] / 100;

        // Insert into database
        $saldo->save();

        return redirect()->intended('/rooms')->with('success', 'Item added successfully!');
    }

    public function viewCheckIn()
    {
        $rooms = Rooms::where('status', 'vacant')->get();

        return view('checkinform', [
            "rooms" => $rooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function CheckIn(Request $request)
    {
        $newCheckIn = $request->validate([
            'guestName' => 'required|max:25|regex:/^[\w\s-]*$/',
            'phone_number' => 'required|max:25|regex:/^[\d\s+-]*$/',
            'email' => 'required|email', // Removed 'unique' constraint
            'room_id' => 'required|numeric|exists:rooms,room_number', // Must be numeric & exist in rooms table
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'room_rate' => 'required|numeric|min:0',
            'payment_method' => 'required'
        ]);

        // Get the actual room ID
        $room = Rooms::where('room_number', $request->room_id)->first();
        if (!$room) {
            return back()->withErrors(['roomNumber' => 'Invalid room number.'])->withInput();
        }

        $saldo = Saldo::find(1);

        // Assign room ID instead of room number
        $newCheckIn['room_id'] = $room->id;

        $check_in = Carbon::parse($request->check_in_date);
        $check_out = Carbon::parse($request->check_out_date);
        $nights = $check_in->diffInDays($check_out);
        if ($nights < 1){
            $nights = 1;
        }

        $newCheckIn['total_amount'] = $newCheckIn['room_rate'] * $nights;
        $newCheckIn['status'] = 'checkIn';
        Bookings::create($newCheckIn);

        // Update auto-stock items
        $items = Items::where('auto_stock', 'checkIn')->get();
        $total = 0;

        foreach ($items as $item) {
            $item->stocks += $item->auto_stock_value;
            $item->save();

            // Store transaction history
            $kasHistory = [
                'qty' => $item->auto_stock_value,
                'description' => $item->name,
                'transaction' => $item->price * $item->auto_stock_value,
            ];

            $kasHistory['saldo'] = $saldo->saldo + $kasHistory['transaction'];

            $total += $kasHistory['transaction'];

            $saldo->saldo += $kasHistory['transaction'];
            $saldo->save();

            Kas::create($kasHistory);
        }

        $price_list = Pricelist::where('auto_stock', 'checkIn')->get();

        foreach ($price_list as $price_list) {
            $price_list->stocks += $price_list->auto_stock_value;
            $price_list->save();
        }

        $room->status = 'occupied';
        $room->save();

        return redirect('/checkin')->with('success', 'Item added successfully!');
    }

    public function CheckOut(Request $request)
    {
        // Get the actual room ID
        $room = Rooms::where('room_number', $request->room_id)->first();
        if (!$room) {
            return back()->withErrors(['roomNumber' => 'Invalid room number.'])->withInput();
        }

        $booking = Bookings::where('room_id', $room->id)
                   ->where('status', 'checkIn')
                   ->first(); // Use get() to retrieve the results

        $booking->status = 'checkOut';
        $booking->save();

        // Update auto-stock items
        $items = Items::where('auto_stock', 'checkOut')->get();
        $total = 0;

        $saldo = Saldo::find(1);

        foreach ($items as $item) {
            $item->stocks += $item->auto_stock_value;
            $item->save();

            // Store transaction history
            $kasHistory = [
                'qty' => $item->auto_stock_value,
                'description' => $item->name,
                'transaction' => $item->price * $item->auto_stock_value,
            ];
            $total += $kasHistory['transaction'];

            $kasHistory['transaction'] = -abs($kasHistory['transaction']);

            $kasHistory['saldo'] = $saldo->saldo + $kasHistory['transaction'];

            $saldo->saldo += $kasHistory['transaction'];
            $saldo->save();

            Kas::create($kasHistory);
        }

        $price_list = Pricelist::where('auto_stock', 'checkOut')->get();

        foreach ($price_list as $price_list) {
            $price_list->stocks += $price_list->auto_stock_value;
            $price_list->save();
        }

        $room->status = 'vacant';
        $room->save();

        return redirect('/rooms')->with('success', 'Check Out Success!');
    }

    // public function additionalitem()
    // {
    //     return view('additionalitem');
    // }

    public function additionalitem(Request $request)
    {
        $room = Rooms::where('room_number', $request->room_id)->first();
        if (!$room) {
            return back()->withErrors(['roomNumber' => 'Invalid room number.'])->withInput();
        }

        $items = Items::all();
        $price_lists = Pricelist::all();

        $bookings = Bookings::where('room_id', $room->id)
                   ->where('status', 'checkIn')
                   ->first(); // Use get() to retrieve the results

        return view('additionalitem', [
            "bookings" => $bookings,
            "items" => $items,
            "price_lists" => $price_lists,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Rooms $rooms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rooms $rooms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rooms $rooms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rooms $rooms)
    {
        //
    }
    public function availableRooms(Request $request)
    {
        $availableRoomsCount = Rooms::where('status', 'vacant')->count();

        // Get today's date or a specific date from the request
        $date = $request->input('date', Carbon::today()->toDateString());

        // Calculate total revenue for the specified date
        $totalRevenue = Bookings::whereDate('check_out_date', $date)
            ->sum('total_amount'); // Assuming 'amount' is the field that holds the revenue

        
        $recentCheckOuts = Bookings::where('status', 'checkout')
        ->orderBy('check_out_date', 'desc') // Assuming 'check_out_date' is the field for check-out date
        ->take(5) // Get the last 5 check-outs
        ->get();

        $recentCheckIn = Bookings::where('status', 'checkin')
        ->orderBy('check_in_date', 'desc') // Assuming 'check_out_date' is the field for check-out date
        ->take(5) // Get the last 5 check-outs
        ->get();
        

        return view('ahotel', [
            'availableRooms' => $availableRoomsCount,
            'totalRevenue' => $totalRevenue,
            'recentCheckOuts' => $recentCheckOuts,
            'recentCheckIn' => $recentCheckIn,

        ]);
    }
}