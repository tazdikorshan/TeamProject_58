<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function filter(Request $request)
    {
        $query = $request->input('query');
        $priceVal = $request->input('priceVal');
        $catVal = $request->input('catVal');

        // Note: The previous logic required a $query but technically a user might just want to filter 
        // a blank search by category/price. We'll enforce $query if they didn't provide any filters
        if (!$query && !$priceVal && !$catVal) {
            return redirect()->back()->with('error', 'Please enter a search term, or select a filter!');
        }

        $resultsQuery = DB::table('products')
            ->join('product_category', 'products.id', '=', 'product_category.product_id')
            ->join('categories', 'product_category.category_id', '=', 'categories.id')
            ->select('products.*', DB::raw('(SELECT url FROM product_media WHERE product_media.product_id = products.id AND media_type = "image" LIMIT 1) as url'));

        // Apply text search
        if ($query) {
            $resultsQuery->where(function ($q) use ($query) {
                $q->where('products.name', 'like', "%{$query}%")
                    ->orWhere('categories.name', 'like', "%{$query}%");
            });
        }

        // Apply category filter
        if ($catVal) {
            $resultsQuery->where('categories.name', 'like', "%{$catVal}%");
        }

        // Apply price filter safely
        if ($priceVal) {
            if ($priceVal == "0-50") {
                $resultsQuery->where('price', '<', 50);
            } elseif ($priceVal == "50-100") {
                $resultsQuery->whereBetween('price', [50, 100]);
            } elseif ($priceVal == "100-200") {
                $resultsQuery->whereBetween('price', [100, 200]);
            } elseif ($priceVal == "200-300") {
                $resultsQuery->whereBetween('price', [200, 300]);
            } elseif ($priceVal == "300+") {
                $resultsQuery->where('price', '>=', 300);
            }
        }

        $results = $resultsQuery->get();

        return view('filter', compact('results', 'query'));
    }

}
