<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Saldo;
use App\Models\Items;
use Illuminate\Http\Request;

class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewKas()
    {
        $cashTransactions = Kas::orderBy('created_at', 'desc')->paginate(10);// Assuming Cash is your model
        $saldo = Saldo::find(1);
        $grandTotal = 0;
        $grandTotal = Kas::sum('transaction') ?? 0;

        return view('viewkas', [
            "cashTransactions" => $cashTransactions,
            "saldo" => $saldo,
            "grandTotal" => $grandTotal
        ]);
    }
    
    public function viewSlide(Request $request)
    {
        $saldo = Saldo::find(1);
        
        // Build the base query for filtering
        $query = Kas::query();
        
        // Apply filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('description', 'like', '%' . $search . '%');
        }
        
        // Get all filtered records (without pagination) for total calculation
        $filteredRecords = $query->get();
        
        // Calculate grand total from filtered records
        $grandTotal = $filteredRecords->sum('transaction');
        
        // Get paginated records for display
        $cashTransactions = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('viewkas', compact('cashTransactions', 'saldo', 'grandTotal'));
    }


    public function addTransaction(Request $request)
    {
        $newKas = $request->validate([
            'description' => 'nullable|string', // Allows null and must be a string
            'qty' => 'nullable|integer|min:0', // Must be an integer, can be null
            'transaction' => 'nullable|integer|min:0', // Must be an integer, can be null
        ]);

        $saldo = Saldo::find(1);

        $saldo->saldo += $newKas['transaction'];
        $saldo->save();

        $newKas['saldo'] = $saldo->saldo;
        Kas::create($newKas);

        return redirect('/viewKas')->with('success', 'Item added successfully!');
    }

    public function delete_kas(Request $request){
        $kas = Kas::find($request->transaction_id);
        $kas->delete();
        return redirect()->intended('/viewKas');
    }

    public function cancel_kas(Request $request) {
        $kas = Kas::find($request->transaction_id);
        if (!$kas) {
            return redirect()->back()->with('error', 'Transaction not found');
        }

        // Cari item berdasarkan name
        $item = Items::where('name', $kas->name)->first();

        if ($item) {
            $item->stocks -= $kas->qty;
            $item->save();
        }

        // Ambil saldo dan update
        $saldo = Saldo::find(1); // Pastikan ada model Saldo
        if ($saldo) {
            $saldo->saldo -= $kas->transaction;
            $saldo->save();
        }

        // Hapus transaksi kas
        $kas->delete();

        return redirect()->intended('/viewKas')->with('success', 'Transaction canceled successfully');
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
    public function show(Kas $kas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kas $kas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kas $kas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kas $kas)
    {
        //
    }
}
