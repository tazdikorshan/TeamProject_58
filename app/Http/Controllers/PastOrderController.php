<?php 
namespace App\Http\Controllers; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

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
        
        //Remove the product from order items 
        $quantity = DB::table('order_items')
            ->select('quantity')
            ->where('order_id', $orderID)
            ->where('product_id', $productID)
            ->first(); 

        //Return the product
        $returnedProduct = DB::table('order_items')
            ->where('order_id', $orderID)
            ->where('product_id', $productID)
            ->delete(); 
        
        //Get old quantity
        $oldQuantity = DB::table('products')
            ->select('stock_quantity')
            ->where('id', $productID)
            ->first(); 

        //Update quantity
        $updateQuantity = DB::table('products')
            ->where('id', $productID)
            ->update([
                'stock_quantity' => $oldQuantity->quantity + $quantity->quantity
            ]);

        
        if ($returnedProduct && $updateQuantity){
            redirect()->route('pastOrders.index')->with('success', 'Product ID of '. $productID . ' of order ' . $orderID. ' has been successfully returned and product stock quantityhas been successfully updated'); 
        } else {
            redirect()->route('pastOrders.index')->with('error', 'Unsuccessful return of product ID '. $productID . ' of order ' . $orderID . ' or unsuccessful updating of products stock quantity'); 
        }
    }

}