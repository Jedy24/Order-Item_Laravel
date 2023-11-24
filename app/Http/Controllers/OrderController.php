<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(){
        /*Mengambil item yang stoknya > 0*/
        $items = Item::where('stok', '>', 0)->get();
        return view('order', compact('items'));
    }

    public function createOrder(Request $request){
        /*Validasi data*/
        $validated = $request->validate([
            'status' => 'required|in:Selesai,Menunggu Pembayaran',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        /*Menghitung harga dengan asumsi pajak 11%*/
        $totalHarga = 0;
        foreach ($validated['items'] as $itemData) {
            $item = Item::find($itemData['item_id']);
            $totalHarga += $item->harga * $itemData['quantity'];
        }
        $totalHargaPajak = $totalHarga * 1.11;

        /*Membuat Order*/
        $order = Order::create([
            'status' => $validated['status'],
            'total_harga' => $totalHargaPajak,
        ]);

        /*Membuat Order Item*/
        foreach ($validated['items'] as $itemData) {
            $order->items()->create([
                'item_id' => $itemData['item_id'],
                'quantity' => $itemData['quantity'],
            ]);

            /*Update Stok Item*/
            $item = Item::find($itemData['item_id']);
            $item->stok -= $itemData['quantity'];
            $item->save();
        }

        return redirect()->route('index')->with('success', 'Order has been created successfully');
    }

//     public function list(){
//         /*Menampilkan seluruh daftar order*/
//         $orders = Order::all();
//         return view('list', compact('orders'));
//     }

//     public function detail(Order $order)
//     {
//         $details = Order::join('order_item', 'orders.id', '=', 'order_item.order_id')
//             ->join('items', 'order_item.item_id', '=', 'items.id')
//             ->get(['order_item.item_id', 'order_item.quantity', 'items.nama', 'items.harga']);

//         $total = 0;
//         foreach ($details as $detail) {
//             $total += $detail->quantity * $detail->harga;
//         }

//         return view('details', compact('order', 'details', 'total'));
//     }
}
