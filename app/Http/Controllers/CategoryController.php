<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    public function show($slug)
    {
        // Convert slug to name (e.g., "home-decor" -> "Home Decor")
        // This is a simple approximation. Ideally, add a slug column to DB.
        $categoryName = str_replace('-', ' ', $slug);

        $results = DB::table('products')
            ->join('product_category', 'products.id', '=', 'product_category.product_id')
            ->join('categories', 'product_category.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                DB::raw('(SELECT url FROM product_media WHERE product_media.product_id = products.id AND media_type = "image" LIMIT 1) as url'),
                'categories.id as category_id',
                'categories.name as category_name'
            )
            ->where('categories.name', 'like', $categoryName)
            ->get();



        return view('category', compact('results', 'slug'));
    }
}
