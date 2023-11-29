<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function order(){
        /**Mengambil item yang stoknya > 0*/
        $items = Item::where('stok', '>', 0)->get();
        return view('order', compact('items'));
    }

    public function createOrder(Request $request)
    {
        $order = Order::create($request->all());

        $items = $request->input('items', []);
        $quantities = $request->input('quantities', []);

        /**Looping untuk menyimpan data order & perubahan stok */
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i] != '') {
                $order->items()->attach($items[$i], ['quantity' => $quantities[$i]]);

                /**Validasi stok item >= quantity */
                $item = Item::find($items[$i]);
                $quantity = $quantities[$i];

                if ($item->stok >= $quantity) {
                    /**Mengurangi stok apabila validasi terpenuhi */
                    $item->stok -= $quantity;

                    /**Menyimpan perubahan stok */
                    $item->save();
                } else {
                    return redirect()->back()->with('error', 'Insufficient stock for item ' . $item->nama);
                }
            }
        }
        return redirect()->route('index')->with('success', 'Order has been created successfully');
    }

    public function list(){
        /*Menampilkan seluruh daftar order*/
        $orders = Order::paginate(10);
        return view('orders.list', compact('orders'));
    }

    public function detail(Order $order)
    {
        /**Query untuk mengambil data item dan order dari order_item*/
        $details = Order::join('order_item', 'orders.id', '=', 'order_item.order_id')
            ->join('items', 'order_item.item_id', '=', 'items.id')
            ->where('orders.id', $order->id)
            ->get(['order_item.item_id', 'order_item.quantity', 'items.nama', 'items.harga']);

        /**Function untuk menghitung total harga */
        $total = 0;
        foreach ($details as $detail) {
            $total += $detail->quantity * $detail->harga;
        }

        return view('orders.detail', compact('order', 'details', 'total'));
    }
}
