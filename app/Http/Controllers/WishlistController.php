<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $wishlistItems = DB::table('wishlist')
            ->join('products', 'wishlist.product_id', '=', 'products.id')
            ->leftJoin('product_media', function ($join) {
                $join->on('products.id', '=', 'product_media.product_id')
                    ->where('product_media.media_type', '=', 'image');
            })
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.description',
                'wishlist.id as wishlist_id',
                DB::raw('MIN(product_media.url) as image_url')
            )
            ->where('wishlist.user_id', $userId)
            ->groupBy('products.id', 'products.name', 'products.price', 'products.description', 'wishlist.id')
            ->get();

        return view('wishlist', compact('wishlistItems'));
    }

    public function add($productId)
    {
        $userId = Auth::id();

        // Check if already in wishlist
        $exists = DB::table('wishlist')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if (!$exists) {
            DB::table('wishlist')->insert([
                'user_id' => $userId,
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function remove($productId)
    {
        $userId = Auth::id();

        DB::table('wishlist')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();

        return redirect()->back()->with('success', 'Product removed from wishlist!');
    }
}
