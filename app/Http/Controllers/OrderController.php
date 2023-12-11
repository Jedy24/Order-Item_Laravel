<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        /**Mengambil item yang stoknya > 0*/
        $items = Item::where('stok', '>', 0)->get();
        return view('order', compact('items'));
    }

    public function store(Request $request){
        DB::beginTransaction();

        try {
            /**Membuat order */
            $order = Order::create($request->all());

            $items = $request->input('items', []);
            $quantities = $request->input('quantities', []);

            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i] != '') {
                    $order->items()->attach($items[$i], ['quantity' => $quantities[$i]]);

                    /**Validasi stok item >= quantity */
                    $item = Item::find($items[$i]);
                    $quantity = $quantities[$i];

                    if ($item->stok >= $quantity) {
                        /**Mengurangi stok jika stok > quantity order */
                        $item->stok -= $quantity;

                        // Menyimpan perubahan stok
                        $item->save();
                    } else {
                        /**Melakukan rollback dan memunculkan notif */
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Insufficient stock for item ' . $item->nama);
                    }
                }
            }

            /**Menyimpan order jika validasi terpenuhi */
            DB::commit();
            return redirect()->route('index')->with('success', 'Order has been created successfully');
        } catch (\Exception $e) {
            /**Rollback jika validasi tidak terpenuhi */
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing the order');
        }
    }

    public function list(){
        /*Menampilkan daftar order*/
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
            $total += $detail->quantity * $detail->harga * 1.11;
        }

        return view('orders.detail', compact('order', 'details', 'total'));
    }
}
