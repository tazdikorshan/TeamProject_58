<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class FeedbackController extends Controller
{

    public function show(Request $request)
    {
        return view('Feedback');
    }


    public function store(Request $request)
    {

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        if ($request->user()) {
            DB::table('site_reviews')->insert([
                'user_id'     => auth()->id(),
                'rating'      => $request->rating,
                'review_text' => $request->review,
                'created_at'  => now(),
                'updated_at'  => now()
            ]);
        }


        return back()->with('success', 'Your review was successfully saved!');
    }
}
