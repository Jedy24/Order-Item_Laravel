<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function order(){
        /*Mengambil item yang stoknya > 0*/
        $items = Item::where('stok', '>', 0)->get();
        return view('order', compact('items'));
    }

    public function createOrder(Request $request)
    {
        $inputs = $request->all();

        /*Mengambil ID & Quantity dari input request*/
        $ids = $request->get('.nama');
        $quantities = $request->get('.quantity');

        /*Validasi jumlah stok*/
        // foreach ($ids as $key => $id) {
        //     $item = Item::find($id);

        //     /*Cek stok item dengan permintaan*/
        //     if (!$item || $item->stok < $quantities[$key]) {
        //         return redirect()->route('order')->with('error', 'Insufficient Stok');
        //     }
        // }

        /*Membuat Order ke DB*/
        // DB::beginTransaction();

        $order = new Order;
        $order->status = $request->get('status');
        $order->save();

        /*Error duplicate primary key karena input 2 item yang sama berdasarkan ID.
          Data tidak tersimpan di table order_item.*/

        /*Menyimpan detil order di table order_item*/
        // foreach ($ids as $key => $id) {
        //     $quantity = isset($quantities[$key]) ? $quantities[$key] : null;

        //     DB::table('order_item')->insert([
        //         'order_id' => $order->id,
        //         'item_id' => $id,
        //         'quantity' => $quantity,
        //     ]);
        // }

        // DB::commit();

        return redirect()->route('index')->with('success', 'Order has been created successfully');
    }

    public function list(){
        /*Menampilkan seluruh daftar order*/
        $orders = Order::all();
        return view('list', compact('orders'));
    }

    public function detail(Order $order)
    {
        $details = Order::join('order_item', 'orders.id', '=', 'order_item.order_id')
            ->join('items', 'order_item.item_id', '=', 'items.id')
            ->get(['order_item.item_id', 'order_item.quantity', 'items.nama', 'items.harga']);

        $total = 0;
        foreach ($details as $detail) {
            $total += $detail->quantity * $detail->harga;
        }

        return view('details', compact('order', 'details', 'total'));
    }
}
