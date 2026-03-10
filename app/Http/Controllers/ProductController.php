<?php

namespace App\Http\Controllers;

use App\Services\PersonalisedAdvertisedService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function show($pid, PersonalisedAdvertisedService $ads)
    {
        //Comment this line in case the join select query fails
        //$product = Products::where('product_id', $pid)->first();
        $rows = DB::table('products')
            ->leftJoin('product_media', 'products.id', '=', 'product_media.product_id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select(
                //Products
                'products.id',
                'products.name',
                'products.sku',
                'products.price',
                'products.stock_quantity',
                'products.description',
                'products.dimensions',
                'products.energy_rating',
                'products.is_available',
                //Media
                'product_media.url',
                'product_media.media_type',
                //Reviews
                'reviews.rating',
                'reviews.review_text',
                'reviews.rating',
                'reviews.submission_date',
                'reviews.is_approved'
            )
            ->where('products.id', $pid)
            ->get();

        //Grouping the data
        $product = [
            'id' => $rows[0]->id,
            'name' => $rows[0]->name,
            'sku' => $rows[0]->sku,
            'price' => $rows[0]->price,
            'stock_quantity' => $rows[0]->stock_quantity,
            'description' => $rows[0]->description,
            'dimensions' => $rows[0]->dimensions,
            'energy_rating' => $rows[0]->energy_rating,
            'is_available' => $rows[0]->is_available,

            /*//Combine the media
            'media' => $rows->map(fn($r) => [
                'type' => $r->media_type,
                'url' => $r->url
            ])->unique('url')->values()->all(),*/

            // Combine the media
            'media' => $rows->map(function ($r) {
                $url = $r->url;

                if ($url) {

                    if (str_starts_with($url, '/images/') || str_starts_with($url, 'images/')) {
                        $finalUrl = asset($url);
                    } else {
                        $finalUrl = asset('storage/' . $url);
                    }
                } else {
                    $finalUrl = asset('images/placeholder.png');
                }

                return [
                    'type' => $r->media_type,
                    'url' => $finalUrl
                ];
            })->unique('url')->values()->all(),

            //Combine the reviews
            'reviews' => $rows->map(fn($r) => [
                'text' => $r->review_text,
                'rating' => $r->rating,
                'approved' => $r->is_approved,
                'submission_date' => $r->submission_date,
                'user' => ['name' => 'Anonymous'] // Placeholder for user name until we join with users table
            ])->unique('text')->values()->all()
        ];

        // Calculate average rating
        $totalRating = 0;
        $reviewCount = count($product['reviews']);
        if ($reviewCount > 0) {
            foreach ($product['reviews'] as $review) {
                $totalRating += $review['rating'];
            }
            $product['average_rating'] = round($totalRating / $reviewCount, 1);
        } else {
            $product['average_rating'] = 0;
        }

        //Suggest products for the user
        $advertisedProducts = $ads->personalisedAdvertising(Auth::id());
        $backupProducts = $ads->generateRandomProducts(5); //Select 5 backup products

        return view('/product', compact('product', 'advertisedProducts', 'backupProducts'));
    }
    public function storeReview(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to submit a review.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        DB::table('reviews')->insert([
            'product_id' => $id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'submission_date' => now(),
            'is_approved' => true, // Auto-approve for MVP
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
