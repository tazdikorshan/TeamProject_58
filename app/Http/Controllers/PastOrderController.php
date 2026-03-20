<?php 
namespace App\Http\Controllers; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PastOrderController extends Controller {
    public function index(){
        //Get general order information of all the orders user has made
        $orders = DB::table('orders')
            ->select(
                'id', 
                'order_date', 
                'total_amount', 
                'status'
            )
            ->where('user_id', Auth::id())
            ->get(); 
        
        
        // Get product items for all orders
        $rows = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_media', 'products.id', '=', 'product_media.product_id')
            ->select(
                'orders.id as order_id',
                'products.id as product_id',
                'products.name',
                'products.price',
                'product_media.url',
                'product_media.media_type',
                'order_items.quantity'
            )
            ->where('orders.user_id', Auth::id())
            ->get();

        //Group the products
        $groupedProducts = $rows->groupBy('order_id')->map(function($items){
            return $items->groupBy('product_id')->map(function($products){
                $first = $products->first(); 

                return [
                    'id' => $first->product_id, 
                    'name' => $first->name, 
                    'price' => $first->price, 
                    'quantity' => $first->quantity, 
                    'media' => $products->map(fn ($r) => [
                        'type' => $r->media_type, 
                        'url' => $r->url
                    ])->filter(fn($m) => $m['url'] !== null)->values() 
                ]; 
            });  
        }); 

        //Attach products to each order
        $ordersWithItems = $orders->map(function ($order) use ($groupedProducts){
            $order->order_items = $groupedProducts[$order->id] ?? []; 
            return $order; 
        }); 

        return view('/pastOrders', array('orders' => $ordersWithItems)); 
    }

    public function returnProduct(Request $request, $orderID, $productID){
        
        //Get the quantity of the order product 
        $quantity = DB::table('order_items')
            ->select('quantity')
            ->where('order_id', $orderID)
            ->where('product_id', $productID)
            ->first(); 

        //Get the price of the product 
        $productPrice = DB::table('products')
            ->select('price')
            ->where('id', $productID)
            ->first();  

        if ($quantity->quantity - 1 > 0){
            $newQuantity = $quantity->quantity - 1; 

            $newTotal = $newQuantity * $productPrice->price; 

            //Update the total amount
            $updatedOrder = DB::table('orders')
                ->where('id', $orderID)
                ->update(['total_amount' => $newTotal]); 

            //Update the order item 
            $updatedOrderItem = DB::table('order_items')
                ->where('order_id', $orderID)
                ->where('product_id', $productID)
                ->update(['quantity' => $newQuantity]); 

            //Increment the stock of that product 
            $updatedStock = DB::table('products')
                ->where('id', $productID)
                ->increment('stock_quantity', 1); 
            
            if($updatedOrder && $updatedOrderItem && $updatedStock){
                redirect()->route('pastOrders.index')->with('success', '1 product ID of product '. $productID . ' of order ' . $orderID. ' has been successfully returned and product stock quantityhas been successfully updated');
            } else {
                redirect()->route('pastOrders.index')->with('error', 'The order total amount, order items quantity of order '. $orderID . ' or stock of product ' . $productID . ' did not update. Product not returned'); 
            }
        } else {
            //If the quantity is 0 so return the product
            $returnedProduct = DB::table('order_items')
                ->where('order_id', $orderID)
                ->where('product_id', $productID)
                ->delete();

            //Increment the stock of that product 
            $updatedStock = DB::table('products')
                ->where('id', $productID)
                ->increment('stock_quantity', 1); 
            
            //Get old order price 
            $oldPrice = DB::table('orders')
                ->select('total_amount')
                ->where('id', $orderID)
                ->first(); 
            
            //Get the order items of the order
            $orderItems = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->select('order_items.*')
                ->where('orders.id', $orderID)
                ->get(); 

            //Check if there is no items in the order and delete the order itself 
            if ($orderItems->isEmpty()){
                $orderDeleted = DB::table('orders')
                    ->where('id', $orderID)
                    ->delete(); 
                
                if ($orderDeleted && $returnedProduct && $updatedStock){
                    return redirect()->route('pastOrders.index')->with('success', 'Product ' . $productID . ' has been returned and the stock has updated, order ' . $orderID . ' is successfully deleted.'); 
                } else {
                    return redirect()->route('pastOrders.index')->with('error', 'Stock has not successfully update, order ' . $orderID . ' has not been deleted or product '. $productID . ' has not successfully returned'); 
                }
            }

            //There are still remaining items so need to delete the order itself 
            $newTotal = $oldPrice->total_amount - $productPrice; 

            //Update the total amount
            $updatedOrder = DB::table('orders')
                ->where('id', $orderID)
                ->update(['total_amount' => $newTotal]); 

            if ($updatedOrder && $returnedProduct && $updatedStock){
                return redirect()->route('pastOrders.index')->with('success', 'Product ' . $productID . ' has successfully returned, stock has updated and order ' . $orderID . ' has updated'); 
            } else {
                return redirect()->route('pastOrders.index')->with('error', 'Stock has not successfully updated or order '. $orderID . ' has not successfully updated. Product ' . $productID . ' has not successfully returned.'); 
            }
        }

    }

}