<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    public function show($slug)
    {
        // Explicit slug → DB category name mapping
        $slugMap = [
            'furniture'   => 'Furniture',
            'appliances'  => 'Appliances',
            'home-decor'  => 'Home Decor',
            'kitchen-ware' => 'Kitchen',
            'lighting'    => 'Lighting',
            'electronics' => 'Electronics',
            'cleaning'    => 'Cleaning',
        ];

        // Fall back to a humanized version of the slug if not in the map
        $categoryName = $slugMap[$slug] ?? ucwords(str_replace('-', ' ', $slug));

        $results = DB::table('products')
            ->join('product_category', 'products.id', '=', 'product_category.product_id')
            ->join('categories', 'product_category.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                DB::raw('(SELECT url FROM product_media WHERE product_media.product_id = products.id AND media_type = "image" LIMIT 1) as url'),
                'categories.id as category_id',
                'categories.name as category_name'
            )
            ->where('categories.name', $categoryName)
            ->where('products.is_available', true)
            ->get();

        return view('category', compact('results', 'slug'));
    }
}
