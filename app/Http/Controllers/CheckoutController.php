<?php
namespace App\Http\Controllers; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

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
            return [
                'id' => $items[0]->id,
                'name' => $items[0]->name,
                'price' => $items[0]->price,
                'quantity' => $items[0]->quantity,
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email' . Auth::id()],
            'street' => ['required', 'string', 'max:255'], 
            'city' => ['required', 'string', 'max:255'], 
            'postcode' => ['required', 'string', 'min:5', 'max:10'],// post code must be 5-10 characters long
            'CHName' => ['required', 'string', 'max:255'], 
            'CardNum' => ['required', 'string', 'min:16', 'max:19'], 
            'ExpDate' => ['required', 'string'],
            'CVV' => ['required', 'string', 'min:3', 'max:4']
        ]); 

        $finalisedPostcode = strtoupper($deliveryFields['postcode']); //Ensure postcode is capitalised
        
        if (!Auth::check()){ //ensure the user is logged in 
            return redirect()->route('login')->with('error', 'You must be logged in to submit an order.');
        } else {
            //Check if name, city or card holder name contains a number 
            if (preg_match('/\d+/', $deliveryFields['name']) || preg_match('/\d+/', $deliveryFields['city']) || preg_match('/\d+/', $deliveryFields['CHName'])){
                return redirect()->route('checkout.index')->with('error', "Your name, city or card number name can't contain any numbers"); 
            }

            //Check if CardNum or CVV contains any letters 
            if (preg_match('/[a-zA-Z]/', $deliveryFields['CardNum']) || preg_match('/[a-zA-Z]/', $deliveryFields['CVV'])){
                return redirect()->route('checkout.index')->with('error', "Your Card Number or CVV can't contain any letters"); 
            }

            //Validate the email to check it follows an appropriate structure
            if (filter_var($deliveryFields['email'], FILTER_VALIDATE_EMAIL)){
                return redirect()->route('checkout.index')->with('error', 'Not a valid email'); 
            }

            //Validating the expiry date 
            if (!preg_match('(0[1-9]|1[0-2])\/[0-9]{2}', $deliveryFields['ExpDate'])){
                return redirect()->route('checkout.index')->with('error', 'Invalid date format for expiry date - use MM/YY'); 
            } else {
                list($month, $year) = explode('/', $deliveryFields['ExpDate']); 

                //Create expiry date with DateTime: https://www.php.net/manual/en/class.datetime.php
                $expiryDate = DateTime::createFromFormat('Y-m-d', "$year-$month-01"); 
                $expiryDate->modify('last day of this month 23:59:59'); 
                //Current date/time 
                $now = new DateTime(); 

                if ($expiryDate < $now){
                    return redirect()->route('checkout.index')->with('error', 'Expiry date has already passed'); 
                }
            }

            $usersNameAndEmail = DB::table('users')
                ->select('name', 'email')
                ->where('id', Auth::id())
                ->first(); 

            if ($usersAndEmail->email !== $deliveryFields['email'] && $usersNameAndEmail->name !== $deliveryFields['name']){
                //Redirect back to the checkout page since the email and name is not consistent 
                return redirect()->route('checkout.index')->with('error', 'Your email/name is not consistent with the email/name you registered with');
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
                return redirect()->route('TBD')->with('success', 'Order has been successfully submitted and status of the order updated to processing'); 
            } else {
                //Redirect back to the checkout page since the insertion has failed
                return redirect()->route('checkout.index')->with('error', 'Something went wrong with the insertion or the updating of the order status.'); 
            }
        }
    }
}