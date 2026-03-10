<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');


        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search term!');
        }


        $results = DB::table('products')
            ->leftJoin('product_category', 'products.id', '=', 'product_category.product_id')
            ->leftJoin('categories', 'product_category.category_id', '=', 'categories.id')
            ->select('products.*', DB::raw('(SELECT url FROM product_media WHERE product_media.product_id = products.id AND media_type = "image" LIMIT 1) as url'))
            ->where(function ($q) use ($query) {
                $q->where('products.name', 'like', "%{$query}%")
                    ->orWhere('categories.name', 'like', "%{$query}%");
            })
            ->distinct()
            ->get();


        return view('search', compact('results', 'query'));
    }
}
