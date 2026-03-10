<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        return view('admin.products.create');
    }

    public function index()
    {
        $products = \App\Models\Product::all();
        $categories = \Illuminate\Support\Facades\DB::table('categories')->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'low_stock_threshold' => $request->low_stock_threshold,
            'is_available' => $request->has('is_available'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->media()->create([
                    'url' => $path,
                    'media_type' => 'image',
                ]);
            }
        }

        return back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        foreach ($product->media as $media) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($media->url);
            $media->delete();
        }

        $product->delete();

        return back()->with('success', 'Product has been removed from inventory.');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'dimensions' => 'nullable|string|max:255',
            'energy_rating' => 'nullable|string|max:50',
            'is_available' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::create([
                'name' => $validatedData['name'],
                'sku' => $validatedData['sku'],
                'price' => $validatedData['price'],
                'stock_quantity' => $validatedData['stock_quantity'],
                'low_stock_threshold' => $validatedData['low_stock_threshold'],
                'description' => $validatedData['description'],
                'dimensions' => $validatedData['dimensions'],
                'energy_rating' => $validatedData['energy_rating'],
                'is_available' => $request->has('is_available'),
            ]);


            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    $path = $image->store('products', 'public');

                    $product->media()->create([
                        'url' => $path,
                        'media_type' => 'image',
                    ]);
                }
            }


            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withInput()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
}
