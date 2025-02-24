<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Pricelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('additemform');
    }

    public function indexsell()
    {
        return view('additemformsell');
    }

    public function viewItems()
    {
        $items = Items::simplePaginate(10);

        return view('logistics', [
            "items" => $items,
        ]);
    }

    public function viewItemsSell()
    {
        $items = Pricelist::simplePaginate(10);

        return view('price_list', [
            "items" => $items,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function add(Request $request)
    {
        $newItem = $request->validate([
            'name' => 'required|max:25|regex:/^[\w\s-]*$/|unique:items,name', // Allows letters, numbers, spaces, hyphens
            'description' => 'required|max:255', // Expanded max length, removed invalid regex
            'price' => 'required|numeric|min:0', // Should be a number, not email validation
            'stocks' => 'required|integer|min:0', // Should be an integer, not `exists`
            'auto_stock' => 'required|in:checkIn,checkOut,none', // Ensures only allowed values
            'auto_stock_value' => 'required|integer',
        ]);
        // Insert into database
        Items::create($newItem);

        return redirect('/additem')->with('success', 'Item added successfully!');
    }

    public function updatelogistic(Request $request)
    {
        $logistics = Items::find($request->item_id);

        $update_logistics = $request->validate([
            'name' => 'required|max:25|regex:/^[\w\s-]*$/|unique:items,name', // Allows letters, numbers, spaces, hyphens
            'description' => 'required|max:255', // Expanded max length, removed invalid regex
            'price' => 'required|numeric|min:0', // Should be a number, not email validation
            'stocks' => 'required|integer|min:0', // Should be an integer, not `exists`
            'auto_stock' => 'required|in:checkIn,checkOut,none', // Ensures only allowed values
            'auto_stock_value' => 'required|integer',
        ]);

        $logistics->name = $update_logistics['name'];
        $logistics->description = $update_logistics['description'];
        $logistics->price = $update_logistics['price'];
        $logistics->stocks = $update_logistics['stocks'];
        $logistics->auto_stock = $update_logistics['auto_stock'];
        $logistics->auto_stock_value = $update_logistics['auto_stock_value'];
        // Insert into database
        $logistics->save();

        return redirect()->intended('/viewItems')->with('success', 'Item added successfully!');
    }

    public function addsell(Request $request)
    {
        $newItem = $request->validate([
            'name' => 'required|max:25|regex:/^[\w\s-]*$/|unique:pricelists,name', // Allows letters, numbers, spaces, hyphens
            'description' => 'required|max:255', // Expanded max length, removed invalid regex
            'price' => 'required|numeric|min:0', // Should be a number, not email validation
            'stocks' => 'required|integer|min:0', // Should be an integer, not `exists`
            'auto_stock' => 'required|in:checkIn,checkOut,none', // Ensures only allowed values
            'auto_stock_value' => 'required|integer',
        ]);
        // Insert into database
        Pricelist::create($newItem);

        return redirect('/additemsell')->with('success', 'Item added successfully!');
    }

    public function editpricelist(Request $request)
    {
        $item = Pricelist::find($request->item_id);
        return view('edit_pricelists', [
            "item" => $item,
        ]);
    }

    public function update_pricelist(Request $request)
    {
        $pricelist = Pricelist::find($request->item_id);

        $update_pricelist = $request->validate([
            'name' => 'required|max:25|regex:/^[\w\s-]*$/|unique:pricelists,name', // Allows letters, numbers, spaces, hyphens
            'description' => 'required|max:255', // Expanded max length, removed invalid regex
            'price' => 'required|numeric|min:0', // Should be a number, not email validation
            'stocks' => 'required|integer|min:0', // Should be an integer, not `exists`
            'auto_stock' => 'required|in:checkIn,checkOut,none', // Ensures only allowed values
            'auto_stock_value' => 'required|integer',
        ]);

        $pricelist->name = $update_pricelist['name'];
        $pricelist->description = $update_pricelist['description'];
        $pricelist->price = $update_pricelist['price'];
        $pricelist->stocks = $update_pricelist['stocks'];
        $pricelist->auto_stock = $update_pricelist['auto_stock'];
        $pricelist->auto_stock_value = $update_pricelist['auto_stock_value'];
        // Insert into database
        $pricelist->save();

        return redirect()->intended('/price_list')->with('success', 'Item added successfully!');
    }

    public function delete_pricelist(Request $request){
        $pricelist = Pricelist::find($request->item_id);
        $pricelist->delete();
        return redirect()->intended('/price_list');
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
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Items $items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Items $items)
    {
        //
    }
    public function viewSlideLogistics(Request $request)
    {
        $query = Items::query(); // Assuming 'Kas' is your model

        // Filter transactions by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
            }
        // Sort transactions by latest date and paginate results
        $items = $query->orderBy('created_at', 'desc')->paginate(10); // 10 items per page

        return view('logistics', compact('items'));
    }
}
