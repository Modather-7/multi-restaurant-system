<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->with(['category', 'restaurant'])
            ->orderBy('id', 'asc')
            ->paginate(6);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(Product $product)
    {
        $user = Auth::user();

        $categories = $user->restaurant->categories();
        $restaurants = $user->restaurant();

        $branches = $user->restaurant->branches;

        return view('dashboard.products.create', compact('product', 'categories', 'restaurants', 'branches'));
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

        $product = Product::create($validated);

        $product->branches()->sync(
            $request->input('branches', [])
        );

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product Added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $user = Auth::user();

        $categories = $user->restaurant->categories();
        $restaurants = $user->restaurant();

        $branches = $user->restaurant->branches;

        return view('dashboard.products.edit', compact('product', 'categories', 'restaurants', 'branches'));
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

        $changes = $product->branches()->sync( // sync() has three status -> (attached, detached, updated)
            $request->input('branches', [])
        );

        $hasChanges = $product->isDirty() || !empty($changes['attached']) || !empty($changes['detached']) || !empty($changes['updated']);

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
            ->with('success', 'product Updated Successfully!');
    }

    /**
     * Trash the specified resource.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.products.index')
            ->with('delete', 'Product Trashed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash()
    {
        $request = request();

        $products = Product::onlyTrashed()
            ->filter($request->query())
            ->paginate();

        return view('dashboard.products.trash', compact('products'));
    }

    public function restore(Request $request, int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('dashboard.products.trash')
            ->with('info', 'Product Restored Successfully!');
    }

    public function forceDelete(int $id)
    {
        $product = Product::onlyTrashed() -> findOrFail($id);
        $product->forceDelete();

        // to delete the image from the storage/app/public file
        if($product->image) {
            FacadesStorage::disk('public')->delete($product->image);
        }

        return redirect()->route('dashboard.products.trash')
            ->with('delete', 'Product Deleted Forever!');
    }
}
