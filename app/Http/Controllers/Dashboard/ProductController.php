<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();

        $products = Product::filter($request->query())
            ->with('category')
            ->orderBy('id', 'asc')
            ->paginate(2);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(Product $product)
    {
        $categories = Category::select('id', 'name')->get();

        return view('dashboard.products.create', compact('categories', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product Added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $old_image = $product->image;

        if ($request->hasFile('image')) {
            // store the new image
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->fill($validated);
        $hasChanges = $product->isDirty();

        if( ! $hasChanges) {
            return redirect()->route('dashboard.products.index')
                ->with('info', 'No changes were made');
        }

        // delete the old image
        if($request->hasFile('image') && $old_image) {
            FacadesStorage::disk('public')->delete($old_image);
        }

        $product -> save();

        return redirect()->route('dashboard.products.index')
            ->with('success', 'product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // to delete the image from the storage/app/public file
        if($product->image) {
            FacadesStorage::disk('public')->delete($product->image);
        }

        return redirect()->route('dashboard.products.index')
            ->with('delete', 'Product Deleted Successfully');
    }
}
