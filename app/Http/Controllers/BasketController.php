<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\PersonalisedAdvertisedService; 

class BasketController extends Controller
{
    public function listProducts(PersonalisedAdvertisedService $ads)
    {
        //Get the products that the user has put into the basket
        $basketProducts = DB::table('shopping_basket')
            ->join('products', 'shopping_basket.product_id', '=', 'products.id')
            ->select(
                'shopping_basket.id', // Basket ID (for deletion)
                'shopping_basket.quantity',
                'shopping_basket.product_id',
                'products.name',
                'products.price'
            )
            ->where('shopping_basket.user_id', Auth::id()) //User ID
            ->get();

        // Attach first image to each product
        foreach ($basketProducts as $product) {
            $media = DB::table('product_media')
                ->where('product_id', $product->product_id)
                ->where('media_type', 'image')
                ->first();
            $product->url = $media ? $media->url : null;
        }

        //Suggest products for the user
        $advertisedProducts = $ads->personalisedAdvertising(Auth::id()); 
        $backupProducts = $ads->generateRandomProducts(5); //Select 5 backup products
        
        return view('basket', compact('basketProducts', 'advertisedProducts', 'backupProducts'));
    }


    public function removeProduct(Request $request, $basket_id)
    {
        //Remove the product based on it's basket id
        $removeProductFromBasket = DB::table('shopping_basket')
            ->where('id', $basket_id)
            ->delete();

        //Validate delete operation
        if ($removeProductFromBasket) {
            return redirect()->route('Basket')->with('success', 'Successfully removed product from basket');
        } else {
            return redirect()->route('Basket')->with('error', 'Unable to remove product from the basket');
        }
    }

    public function addProduct(Request $request, $product_id)
    {
        //Validate the quantity so that it is an integer and it's minimum is 1
        $validateQuantity = $request->validate(['quantity' => 'required|integer|min:1']);

        // Check if product already exists in basket for this user
        $existingItem = DB::table('shopping_basket')
            ->where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->first();

        if ($existingItem) {
            // Update quantity if item exists
            $productInsert = DB::table('shopping_basket')
                ->where('id', $existingItem->id)
                ->update([
                    'quantity' => $existingItem->quantity + $validateQuantity['quantity']
                ]);
        } else {
            // Insert new item

            //If user isn't logged in
            if (!Auth::check()){
                return redirect()->route('login')->with('error', 'You must be logged in to add a product.');
            }

            $productInsert = DB::table('shopping_basket')
                ->insert([
                    'user_id' => Auth::id(),
                    'product_id' => $product_id,
                    'quantity' => $validateQuantity['quantity']
                ]);
        }

        //Verify insert operation
        if ($productInsert) {
            return redirect()->route('Basket')->with('success', 'Successfully added product to the basket');
        } else {
            return redirect()->route('Basket')->with('error', 'Unable to add product to the basket');
        }
    }

    public function updateQuantity(Request $request, $basket_id)
    {
        $quantity = $request->quantity;

        if ($quantity <= 0) {
            $quantity = 1; //Overwrite quantity to 1 so that it's default is 1
        }
        $update = DB::table('shopping_basket')
            ->where('id', $basket_id)
            ->update([
                'quantity' => $quantity,
            ]);


        if ($update) {
            return redirect()->route('Basket')->with('success', 'Successfully updated quantity');
        } else {
            return redirect()->route('Basket')->with('error', 'Unable to update the quantity');
        }
    }
}
