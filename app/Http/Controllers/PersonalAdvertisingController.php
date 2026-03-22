<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PersonalAdvertisingController {

    //Get ids of the products of the users past orders
    public function getProductIDandCategoryBought(){
        $productsBought = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_category', 'order_items.product_id', '=', 'product_category.product_id')
            ->join('categories', 'product_category.category_id', '=', 'categories.id')
            ->select('products.id as product_id', 'categories.name as category_name')
            ->where('orders.user_id', Auth::id())
            ->get(); 
        return $productsBought; 
    }

    //Get all ids of products from a certain category
    public function getAllProductIdByCategory($category){
        $allProductIDs = DB::table('products')
            ->join('product_category', 'products.id', '=', 'product_category.product_id')
            ->join('categories', 'product_category.category_id', '=', 'categories.id')
            ->select('products.id')
            ->where('categories.name', $category)
            ->get(); 
        return $allProductIDs; 
    }

    //Get the ids that the user has not bought
    public function getMissingIDs($allIDs, $boughtIDs){
        $missingIDs = array_values(array_diff($allIDs, $boughtIDs)); 
        return $missingIDs; 
    }

    //Add a category to dictionary (associative array of arrays) if category doesnt exist
    //And append item to that category if it doesn't exist in that array
    //&$dict and not $dict is used because we want to mutate the dict not mutate a copy of the dict
    public function addToDictionaryIfNotExist(&$dict, $group, $item){
        if (!array_key_exists($group, $dict)){
            $dict[$group] = []; //Create an empty array if it doesn't exist
        }
        if (!in_array($item, $dict[$group], true)){
            $dict[$group][] = $item; //Add item to an array if it doesn't exist
        }
    }

    //&$dict used to mutate the dict into a sorted dict 
    public function compareArrayLengthInDict(&$dict){
        uasort($dict, function($indexA, $indexB){
            if(!is_array($indexA) || !is_array($indexB)){
                return 0; 
            } else {
                return count($indexA) <=> count($indexB); //Sort in ascending order
            }
        }); 
        //https://www.php.net/manual/en/function.uasort.php - uasort function document to preserve keys
    }

    //Generate a certain amount of random ids of products 
    public function generateRandomIdArray($randomAmount){
        $randomProductIds = []; 

        //Collecting all the product ids
        $allProductIds = DB::table('products')
            ->select('id')
            ->get(); 

        for($i = 0; $i < $randomAmount; $i++){
            $inArray = true; //Set initial flag
            while ($inArray){
                //Keep selecting random products until the product selected is not in the array
                $randomProduct = array_rand($allProductIds); 
                $inArray = in_array($randomProductIds, $randomProduct, true); 
            }
            $randomProductIds[] = $randomProduct; //Add randomly selected product to array 
        }

        return $randomProductIds; 
    }

    //Get products based on length of the array in the associative array of arrays
    //Items in the array with the smallest length will be chosen
    public function chooseElementsBasedOnArrayLength($dict, $randomAmount){
        $chosenElements = []; 

        foreach($dict as $array){
            if ($randomAmount <= 0){ //If the selection amount is less than or equal to 0 then finish
                break; 
            }
            if (!is_array($array)){
                continue; //Skip over if this is not an array 
            }

            //If statement must be done after the checker of whether it is an array
            if (count($array) == 0){
                continue; //Skip over if the array is empty 
            }

            foreach($array as $item){
                //Ensure no duplicates of the same item
                if (!in_array($chosenElements, $item, true)){
                    $chosenElements[] = $item; 
                    $randomAmount -= 1; 
                }
                //If the selection amount is less than or equal to 0 then finish
                //Even if there are still elements left in the array
                if ($randomAmount <= 0){ 
                    break; 
                }
            }
        }
        return $chosenElements; //Return the selected items 
    }

    //Considering the id array given - return the product information about those product ids
    public function getProductsById($idArray){
        $products = []; 
        foreach($idArray as $id){
            $rows = DB::table('products')
                ->leftJoin('product_media', 'products.id', '=', 'product_media.product_id')
                ->select(
                    //Products
                    'products.id',
                    'products.name',
                    //sku, stock_quantity, description, dimensions, energy_rating, is_available omitted
                    //may be added later in case those informations are required
                    'products.price',
                    //Media
                    'product_media.url',
                    'product_media.media_type',
                )
                ->where('products.id', $id)
                ->get(); 

            //Grouping the medias - if more than one url is present
            $product = [
                'id' => $rows[0]->id,
                'name' => $rows[0]->name,
                'price' => $rows[0]->price,

                //Combine the media
                'media' => $rows->map(fn($r) => [
                    'type' => $r->media_type,
                    'url' => $r->url
                ])->unique('url')->values()->all(),
            ]; 
            $products[] = $product; 
        }
    }

    //Main method for personalised advertising 
    public function personalisedAdvertising(){
        $SELECTION_AMOUNT = 5; //constant for the amount of products to be advertised, can be changed anytime

        //Collect all the product IDs and categories that the user has bought
        $boughtProducts = getProductIDandCategoryBought(); 

        //Collect all the productIDs in general - will be referenced later 
        $allProductIDs = DB::table('products')
            ->select('id')
            ->get(); 
        

        if (count($boughtProducts) == 0){
            //Generate random set of product if user hasn't bought anything 
            $randomlySelectedIDs = generateRandomIdArray($SELECTION_AMOUNT); 
            $advertisedProducts = getProductsById($randomlySelectedIDs); 
        } else {
            $categoryProductDict = []; //Associative array of categories with array of products
            
            foreach($boughtProducts as $product){
                $category = $boughtProducts->category_name; 
                $id = $boughtProducts->product_id; 
                addToDictionaryIfNotExist($categoryProductDict, $category, $id); //Add id to array of specific category
            }

            //Assuming each array of each category contains no duplicates - get length of each set 
            $totalAmountOfIdsBought = 0; 
            foreach($categoryProductDict as $category){
                $totalAmountOfIdsBought += count($category); 
            }

            //If user has bought every product at least once 
            if ($totalAmountOfIdsBought == count($allProductIDs)){
                $randomlySelectedIDs = generateRandomIdArray($SELECTION_AMOUNT); 
                $advertisedProducts = getProductsById($randomlySelectedIDs); 
            } else {
                //If the user has bought some products but NOT all products

                $categoryMissingProductDict = []; //Array of arrays of product ids not bought
                $categoryNames = array_keys($categoryProductDict); 
                foreach ($categoryNames as $category){
                    //Get all product ids and bought products ids of a certain category
                    $productIDsFromCategory = getAllProductIdByCategory($category); 
                    $productIDsBoughtFromCategory = $categoryProductDict[$category];
                    $missingIDFromCategory = []; //instantiate an empty array so that if check fails insert empty array

                    if (is_array($productIDsFromCategory) && is_array($productIDsBoughtFromCategory)){
                        $missingIDFromCategory = getMissingIDs($productIDsFromCategory, $productIDsBoughtFromCategory); 
                    }

                    if(!array_key_exists($category, $categoryMissingProductDict)){
                        $categoryMissingProductDict[$category] = $missingIDFromCategory; 
                    } else {
                        //If category already exists - add all missing IDs 
                        $categoryMissingProductDict[$category][] = $missingIDFromCategory; 
                    }
                }

                //Order the missing product dict based on array length
                compareArrayLengthInDict($categoryMissingProductDict); 

                $advertisedIDs = chooseElementsBasedOnArrayLength($categoryMissingProductDict, $SELECTION_AMOUNT); 
                $advertisedProducts = getProductsById($advertisedIDs); 
            }
        }
        return $advertisedProducts; 
    }


}