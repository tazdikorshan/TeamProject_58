<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $message = strtolower($request->message);
        $products = Product::all();
        foreach ($products as $product) {
            $productName = strtolower($product->name);
            if (str_contains($message, $productName)) {
                return response()->json([
                    'reply' => "{$product->name} costs £{$product->price} and we have {$product->stock_quantity} in stock."
                    ]);
            }
        }
        if (str_contains($message, 'products')) {
            $reply = "Here are some of our products:";
            foreach ($products as $product) {
                $reply .= "{$product->name} - £{$product->price} ({$product->stock_quantity} available)";
            }
            return response()->json(['reply' => $reply]);
        }
        if (str_contains($message, 'stock')) {
            foreach ($products as $product) {
                if (str_contains($message, strtolower($product->name))) {
                    return response()->json([
                        'reply' => "We currently have {$product->stock_quantity} {$product->name}(s) available."
                    ]);
                }
            }
        }
        if (str_contains($message, 'price') || str_contains($message, 'cost')) {
            foreach ($products as $product) {
                if (str_contains($message, strtolower($product->name))) {
                    return response()->json([
                        'reply' => "The price of {$product->name} is £{$product->price}."
                    ]);
                }
            }
        }
        if (str_contains($message, 'size') || str_contains($message, 'dimension')) {
            foreach ($products as $product) {
                if (str_contains($message, strtolower($product->name))) {
                    return response()->json([
                        'reply' => "The price of {$product->name} is £{$product->dimensions}."
                    ]);
                }
            }
        }
        if (str_contains($message, 'order')) {
            preg_match('/\d+/', $message, $match);
            if (isset($match[0])) {
                $order = Order::find($match[0]);
                if ($order) {
                    return response()->json([
                        'reply' => "Order #{$order->order_id} status: {$order->status} products: {$order->product_id} price: {$order->total_amount}"
                    ]);
                }
                return response()->json([
                    'reply' => "Sorry, I couldn't find that order."
                ]);
            }
            return response()->json([
                'reply' => "Please enter an order number."
            ]);
        }
        return response()->json([
            'reply' => "Sorry, I didn't understand that. I can solve any queries regarding products, price, stock or orders. "
        ]);
    }
}