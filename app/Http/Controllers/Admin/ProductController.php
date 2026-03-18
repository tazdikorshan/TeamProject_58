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

    public function index(Request $request)
    {
        /*$products = \App\Models\Product::all();
        $categories = \Illuminate\Support\Facades\DB::table('categories')->get();
        return view('admin.products.index', compact('products', 'categories'));*/

        $categories = \Illuminate\Support\Facades\DB::table('categories')->get();

        $query = \App\Models\Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', $search);
            });
        }

        if ($request->filled('category_id')) {
            $query->whereIn('id', function ($q) use ($request) {
                $q->select('product_id')
                    ->from('product_category')
                    ->where('category_id', $request->category_id);
            });
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'out') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($request->stock_status == 'low') {
                $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold')->where('stock_quantity', '>', 0);
            } elseif ($request->stock_status == 'in') {
                $query->whereColumn('stock_quantity', '>', 'low_stock_threshold');
            }
        }

        $products = $query->latest()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $media=product_media::findOrFail($id);

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





        \Illuminate\Support\Facades\DB::table('product_category')->updateOrInsert(
            ['product_id' => $product->id],
            ['category_id' => $request->category_id,]
        );

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/productImages', 'public');
                $product->media()->create([
                    'url' => $path,
                    'media_type' => 'image',
                ]);
            }
        }


          $product = DB::table('products')
                  ->where('name', 'like', "%{$request->name}%")
                  ->first();

              if ($product) {
                  DB::table('product_media')->insert([
                      'product_id' => $product->id,
                      'media_type' => 'image',
                      'url'        => $path
                  ]);

                  return back()->with('success', 'Product updated successfully!');
              }

        return back()->with('success', 'Product updated successfully!');
    }

    public function restock(Request $request, $id)
    {
        $request->validate([
            'restock_amount' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);

        $product->increment('stock_quantity', $request->restock_amount);

        return back()->with('success', "Incoming order processed: Added {$request->restock_amount} units to {$product->name}!");
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
            'category_id' => 'required|exists:categories,id',
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

            \Illuminate\Support\Facades\DB::table('product_category')->insert([
                'product_id' => $product->id,
                'category_id' => $request->category_id,
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
