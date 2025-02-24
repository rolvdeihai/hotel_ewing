<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Rooms;
use App\Models\XItems;
use App\Models\Items;
use App\Models\Saldo;
use App\Models\Kas;
use App\Models\Pricelist;
use Illuminate\Http\Request;
use Carbon\Carbon;



class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function booking(Request $request)
    {
        $room = Rooms::where('room_number', $request->room_id)->first();
        if (!$room) {
            return back()->withErrors(['roomNumber' => 'Invalid room number.'])->withInput();
        }

        $bookings = Bookings::where('room_id', $room->id)
                   ->where('status', 'checkIn')
                   ->first(); // Use get() to retrieve the results

        $xitems = XItems::where('booking_id', $bookings->id ?? null)->get();

        return view('booking', [
            "bookings" => $bookings,
            "xitems" => $xitems,
        ]);
    }

    public function editbooking(Request $request)
    {
        $booking = Bookings::find($request->booking_id);

        // $bookings->

        $xitems = XItems::where('booking_id', $booking->id ?? null)->get();

        $items = Pricelist::all();

        return view('editbooking', [
            "booking" => $booking,
            "xitems" => $xitems,
            "items" => $items
        ]);
    }

    public function updatebooking(Request $request)
    {
        // **1. Validate Input Data**
        $validatedData = $request->validate([
            'guestName' => 'required|max:25|regex:/^[\w\s-]*$/',
            'phone_number' => 'required|max:25|regex:/^[\d\s+-]*$/',
            'email' => 'required|email',
            // 'room_number' => 'required|numeric|exists:rooms,room_number',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'room_rate' => 'required|numeric|min:0',
            // 'total_amount' => 'nullable|numeric|min:0',
            // 'payment_method' => 'required',
            'xitem_id' => 'nullable|array',
            'xitem_id.*' => 'exists:x_items,id',
            'item_id' => 'nullable|array',
            'item_id.*' => 'exists:pricelists,id',
            'quantity' => 'nullable|array',
            'quantity.*' => 'numeric|min:1',
            // 'booking_status' => 'required|in:CheckIn,CheckOut',
        ]);

        // **2. Find the Booking**
        $booking = Bookings::find($request->booking_id);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        // **3. Find the Room**
        $room = Rooms::where('room_number', $request->room_number)->first();
        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        // **4. Update Booking Data**
        $booking->guestName = $request->guestName;
        $booking->room_id = $room->id;
        $booking->email = $request->email;
        $booking->phone_number = $request->phone_number;
        $booking->check_in_date = Carbon::parse($request->check_in_date);
        $booking->check_out_date = Carbon::parse($request->check_out_date);
        $booking->room_rate = $request->room_rate;

        // **5. Calculate Number of Nights**
        $nights = $booking->check_in_date->diffInDays($booking->check_out_date);
        if ($nights < 1){
            $nights = 1;
        }

        // **6. Calculate Total Amount**
        if (!$request->total_amount) {
            $booking->total_amount = $booking->room_rate * $nights;
        } else {
            $booking->total_amount = $request->total_amount;
        }

        // **7. Update XItems If Provided**
        if ($request->filled('xitem_id')) {
            foreach ($request->xitem_id as $index => $xitemId) {
                $xitem = XItems::find($xitemId);
                if ($xitem) {
                    $xitem->pricelist_id = $request->item_id[$index];
                    $xitem->qty = $request->quantity[$index];
                    $booking->total_amount += $xitem->qty * $xitem->pricelists->price;
                    $xitem->save();
                }
            }
        }

        // **8. Save the Booking**
        $booking->save();

        // **9. Determine Next Action Based on Booking Status**
        if ($booking->status == 'CheckIn') {
            $bookings = Bookings::where('room_id', $room->id)
                ->where('status', 'checkIn')
                ->first();

            $xitems = XItems::where('booking_id', $bookings->id ?? null)->get();

            return view('booking', [
                "bookings" => $bookings,
                "xitems" => $xitems,
            ]);
        } else {
            $bookings = Bookings::where('status', 'checkOut')->get();
            $bookingIds = $bookings->pluck('id')->toArray();
            $xitems = XItems::whereIn('booking_id', $bookingIds)->get();

            return view('transactions', [
                "bookings" => $bookings,
                "xitems" => $xitems,
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function add_xitem(Request $request)
    {
        // Pastikan booking_id ada
        if ($request->has('booking_id')) {
            $booking = Bookings::find($request->booking_id);
            if (!$booking) {
                return back()->withErrors(['error' => 'Booking not found']);
            }

            // Jika pricelist_id ada, update atau tambahkan item
            if ($request->filled('pricelist_id')) {
                $pricelist = Pricelist::find($request->pricelist_id);
                if (!$pricelist) {
                    return back()->withErrors(['error' => 'Pricelist not found']);
                }

                // Cek apakah item sudah ada berdasarkan pricelist_id & booking_id
                $existingXItem = XItems::where('pricelist_id', $request->pricelist_id)
                                    ->where('booking_id', $request->booking_id)
                                    ->first();

                if ($existingXItem) {
                    // Jika sudah ada, tambahkan quantity
                    $existingXItem->qty += $request->quantity;
                    $existingXItem->save();
                } else {
                    // Jika belum ada, buat entri baru
                    XItems::create([
                        'booking_id' => $request->booking_id,
                        'pricelist_id' => $request->pricelist_id,
                        'qty' => $request->quantity,
                    ]);
                }

                // Update total_amount di booking
                $booking->total_amount += ($pricelist->price * $request->quantity);
                $booking->save();
            }
        }

        // Lanjutkan ke proses item jika item_id ada
        if ($request->has('item_id')) {
            $items = Items::find($request->item_id);
            if ($items) {
                $saldo = Saldo::find(1);
                if (!$saldo) {
                    return back()->withErrors(['error' => 'Saldo not found']);
                }

                $transactionAmount = $items->price * $request->quantity * -1;

                // Update stok item
                $items->stocks -= $request->quantity;
                $items->save();

                // Update saldo
                $saldo->saldo += $transactionAmount;
                $saldo->save();

                // Simpan transaksi ke Kas
                Kas::create([
                    'qty' => -($request->quantity),
                    'description' => $items->name,
                    'transaction' => $transactionAmount,
                    'saldo' => $saldo->saldo,
                ]);
            }
        }

        // Ambil booking jika booking_id ada
        $bookings = Bookings::find($request->booking_id);
        $xitems = XItems::where('booking_id', $bookings->id ?? null)->get();

        return view('booking', [
            "bookings" => $bookings,
            "xitems" => $xitems,
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
    public function show(Bookings $bookings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookings $bookings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookings $bookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteBooking(Request $request){
        $booking = Bookings::find($request->booking_id);
        $rooms = Rooms::find($booking->room_id);
        $rooms->status = 'vacant';
        $rooms->save();
        $booking->delete();
        return redirect()->intended('/rooms');
    }

    // public function viewSlideTransactions(Request $request)
    // {
    //     $query = Bookings::query(); // Assuming 'Kas' is your model
    //     $xitems = XItems::all();
    //     // Filter transactions by date range
    //     if ($request->filled('start_date') && $request->filled('end_date')) {
    //         $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    //     }

    //     // Sort transactions by latest date and paginate results
    //     $bookings = $query->orderBy('created_at', 'desc')->paginate(10); // 10 items per page

    //     return view('transactions', compact('bookings','xitems'));
    // }



    // public function SearchBookings(Request $request)
    // {
    //     // Get the search query from the request
        

    //     $xitems = XItems::all();


    //     // Query the database for bookings
    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         // Use the 'like' operator to filter by guest name
    //         // $bookings = Bookings::where('guestName', 'like', '%' . $search . '%')->get();
    //         $bookings = Bookings::where('guestName', 'like', '%' . $search . '%')->get();
    //         // $bookings = Bookings::all();
    //     } else {
    //         // If no search query, get all bookings
    //         $bookings = Bookings::all();
    //     }

    //     return view('transactions', compact('bookings','xitems'));

    //     // Return the view with the bookings data
    // }
    public function viewSlideTransactions(Request $request){
        $query = Bookings::query();
        $xitems = XItems::all();
        
        // Default grand total to 0
        $grandTotal = 0;
        
        // Filter transactions by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('check_in_date', [$request->start_date, $request->end_date]);
                    

        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('guestName', 'like', '%' . $search . '%');
        }

        // Clone the query for total calculation
                // Calculate grand total from the cloned query
        $grandTotal = $query->sum('total_amount') ?? 0;

        // Get paginated results
        $bookings = $query->orderBy('check_in_date', 'desc')->paginate(10);

        return view('transactions', compact('bookings', 'xitems', 'grandTotal'));


    }
    
}    
