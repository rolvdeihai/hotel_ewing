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
        $bookings = Bookings::where('status', 'checkOut')->get(); // Retrieves multiple records

        // Extract all booking IDs
        $bookingIds = $bookings->pluck('id')->toArray();

        // Fetch XItems that match any booking_id in the retrieved bookings
        $xitems = XItems::whereIn('booking_id', $bookingIds)->get();

        return view('transactions', [
            "bookings" => $bookings,
            "xitems" => $xitems,
        ]);
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
