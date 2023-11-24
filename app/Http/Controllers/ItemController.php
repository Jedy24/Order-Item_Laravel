<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*Generate ID secara random*/
        $var_id = random_int(0000000000000000, 9999999999999999);

        /*Mengecek ID agar tidak terjadi duplikat*/
        while (Item::where('id', $var_id)->exists()) {
            $var_id = random_int(0000000000000000, 9999999999999999);
        }

        return view('items.create', compact('var_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'id' => 'required|min:16|max:16',
            'nama' => 'required|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0'
        ]);

        Item::create($validasi);

        return redirect()->route('items.index')->with('success', 'New item added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validasi = $request->validate([
            'id' => 'required|min:16|max:16',
            'nama' => 'required|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0'
        ]);

        /*Update item*/
        $item->update([
            'id' => $validasi['id'],
            'nama' => $validasi['nama'],
            'harga' => $validasi['harga'],
            'stok' => $validasi['stok'],
        ]);

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        /*Menghapus item*/
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }
}
