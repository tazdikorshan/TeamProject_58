<?php
namespace App\Http\Controllers; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckoutController extends Controller { 

    public function index($orderID){
        $rows = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_media', 'products.id', '=', 'product_media.product_id')
            ->select(
                'products.id', 
                'products.name', 
                'products.price', 
                'product_media.url', 
                'product_media.media_type', 
                'order_items.quantity'
            )
            ->where('orders.id', $orderID)
            ->get(); 

        
        $orderedProducts = $rows->groupBy('id')->map(function ($items) {
            $first = $items->first(); 
            return [
                'id' => $first->id,
                'name' => $first->name,
                'price' => $first->price,
                'quantity' => $first->quantity,
                'media' => $items->map(fn($r) => [
                    'type' => $r->media_type,
                    'url' => $r->url
                ])->unique('url')->values()->all()
            ];
        })->values();


        $orderInformation = DB::table('orders')
            ->select('id as orderID', 'total_amount as subtotal')
            ->where('id', $orderID)
            ->first();  
            
        return view('/CheckOutPage', compact('orderedProducts', 'orderInformation')); 
    }

    public function submitDetails(Request $request, $orderID){
        $deliveryFields = $request->validate([
            'name' => ['required', 'string', 'max:255', 'not_regex:/\d/'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::id()],
            'street' => ['required', 'string', 'max:255'], 
            'city' => ['required', 'string', 'max:255', 'not_regex:/\d/'], 
            'postcode' => ['required', 'string', 'min:5', 'max:10'],
            'CHName' => ['required', 'string', 'max:255', 'not_regex:/\d/'], 
            'CardNum' => ['required', 'digits_between:16,19'], 
            'ExpDate' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'CVV' => ['required', 'digits_between:3,4']
        ]);   

        $finalisedPostcode = strtoupper($deliveryFields['postcode']); //Ensure postcode is capitalised

        if (!preg_match('/^(0[1-9]|1[0-2])\/[0-9]{2}$/', $deliveryFields['ExpDate'])){
                return redirect()->route('checkout.index', ['id' => $orderID])->with('error', 'Invalid date format for expiry date - use MM/YY'); 
        } else {
            list($month, $year) = explode('/', $deliveryFields['ExpDate']); 
            $yearFull = 2000 + (int) $year; 
            $monthInt = (int) $month; 
                
            $expiryEnd = Carbon::create($yearFull, $monthInt, 1, 23, 59, 59)->endOfMonth();
            if ($expiryEnd->lt(now())) {
                return redirect()->route('checkout.index', ['id' => $orderID])->with('error', 'Expiry date has already passed.');
            } 
        }
        $usersNameAndEmail = DB::table('users')
                ->select('name', 'email')
                ->where('id', Auth::id())
                ->first(); 

        if ($usersNameAndEmail->email !== $deliveryFields['email'] || $usersNameAndEmail->name !== $deliveryFields['name']){
            //Redirect back to the checkout page since the email and name is not consistent 
            return redirect()->route('checkout.index', ['id' => $orderID])->with('error', 'Your email/name is not consistent with the email/name you registered with');
        }

        $addressID = DB::table('addresses')
            ->insertGetId([
                'user_id' => Auth::id(), 
                'street' => $deliveryFields['street'], 
                'city' => $deliveryFields['city'], 
                'postcode' => $finalisedPostcode
            ]); 
              
        //Update order status to processing instead of pending 
        $updatedOrder = DB::table('orders')
            ->where('id', $orderID)
            ->update([
                'status' => 'processing'
            ]); 
                
        if($addressID && $updatedOrder) {
            return redirect()->route('confirmation.index', ['oid' => $orderID])->with('success', 'Order has been successfully submitted and status of the order updated to processing'); 
        } else {
            //Redirect back to the checkout page since the insertion has failed
            return redirect()->route('checkout.index', ['id' => $orderID])->with('error', 'Something went wrong with the insertion or the updating of the order status.'); 
        }
    }
}