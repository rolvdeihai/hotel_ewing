<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

use App\Models\Transactions;
use App\Models\Bookings;
use App\Models\XItems;
use App\Models\Saldo;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Bookings::where('status', 'checkOut')->get();
        $query = Bookings::query();
        // Retrieves multiple records

        // Extract all booking IDs
        $bookingIds = $bookings->pluck('id')->toArray();
        $grandTotal = 0;

        $grandTotal = $query->sum('total_amount') ?? 0;

        $bookings = $query->orderBy('check_in_date', 'desc')->paginate(10);


        // Fetch XItems that match any booking_id in the retrieved bookings
        $xitems = XItems::whereIn('booking_id', $bookingIds)->get();

        return view('transactions', [
            "bookings" => $bookings,
            "xitems" => $xitems,
            "grandTotal" => $grandTotal,
        ]);
    }

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



    public function nota(Request $request)
    {
        $bookings = Bookings::find($request->booking_id);
        $xitems = XItems::where('booking_id', $bookings->id ?? null)->get();
        $saldo = Saldo::find(1);

        $pdf = Pdf::loadView('nota_pdf', [
            "bookings" => $bookings,
            "xitems" => $xitems,
            "saldo" => $saldo,
        ]);

        // Define the file name and path
        $fileName = 'pdf_report_' . date('Ymd_His') . '.pdf';
        $filePath = 'pdfs/' . $fileName;

        // Save PDF to storage/app/public/pdfs (Make sure storage is linked)
        Storage::disk('public')->put($filePath, $pdf->output());

        $bookings->nota = $filePath;
        $bookings->save();

        return view('nota', [
            "bookings" => $bookings,
            "xitems" => $xitems,
            "saldo" => $saldo,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteTransactions(Request $request){
        $booking = Bookings::find($request->booking_id);
        $booking->delete();
        return redirect()->intended('/transactions');
    }
}
