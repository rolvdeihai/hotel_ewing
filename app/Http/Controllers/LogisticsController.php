<?php

namespace App\Http\Controllers;

use App\Models\Logistics;

use App\Models\Items;
use Illuminate\Http\Request;

class LogisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function editlogistics(Request $request)
    {
        $item = Items::find($request->item_id);
        return view('editlogistics', [
            "item" => $item,
        ]);
    }

    public function delete_logistic(Request $request){
        $logistic = Items::find($request->item_id);
        $logistic->delete();
        return redirect()->intended('/viewItems');
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
    public function show(Logistics $logistics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logistics $logistics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logistics $logistics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logistics $logistics)
    {
        //
    }
}
