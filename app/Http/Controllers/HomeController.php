<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->leftJoin('product_media', function($join) {
                $join->on('products.id', '=', 'product_media.product_id')
                     ->where('product_media.media_type', '=', 'image');
            })
            ->select('products.*', DB::raw('MIN(product_media.url) as url'))
            ->where('products.is_available', true)
            ->groupBy('products.id')
            ->take(25)
            ->get();

        return view('home', compact('products'));
    }



}
