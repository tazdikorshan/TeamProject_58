<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function checkout()
    {
        $userId = Auth::id();

        // 1. Fetch basket items
        $basketItems = DB::table('shopping_basket')
            ->join('products', 'shopping_basket.product_id', '=', 'products.id')
            ->select('shopping_basket.*', 'products.price')
            ->where('shopping_basket.user_id', $userId)
            ->get();

        if ($basketItems->isEmpty()) {
            return redirect()->route('Basket')->with('error', 'Your basket is empty.');
        }

        // 2. Calculate total amount
        $totalAmount = 0;
        foreach ($basketItems as $item) {
            $totalAmount += $item->price * $item->quantity;
        }

        // 3. Create Order
        $orderId = DB::table('orders')->insertGetId([
            'user_id' => $userId,
            'order_date' => Carbon::now(),
            'total_amount' => $totalAmount,
            'status' => 'Pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 4. Create Order Items
        foreach ($basketItems as $item) {
            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Decrement stock
            DB::table('products')->where('id', $item->product_id)->decrement('stock_quantity', $item->quantity);
        }

        // 5. Clear Basket
        DB::table('shopping_basket')->where('user_id', $userId)->delete();

        // 6. Redirect with success
        return redirect()->route('checkout.index', ['id' => $orderId])->with('success', 'Order placed successfully! Order ID: ' . $orderId);
    }
}
