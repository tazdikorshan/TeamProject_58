<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::with(['user', 'items.product'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Processing,Shipped,Delivered,Cancelled'
        ]);

        $order = Order::with('items.product')->findOrFail($id);

        $newStatus = strtolower($request->status);
        $oldStatus = strtolower($order->status);

        DB::beginTransaction();
        try {
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    DB::table('products')
                        ->where('id', $item->product_id)
                        ->increment('stock_quantity', $item->quantity);
                }
            }

            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    DB::table('products')
                        ->where('id', $item->product_id)
                        ->decrement('stock_quantity', $item->quantity);
                }
            }

            $order->update(['status' => $request->status]);
            DB::commit();

            return back()->with('success', 'Status updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()]);
        }
    }
}
