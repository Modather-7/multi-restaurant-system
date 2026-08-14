<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

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
        $user = Auth::guard('admin')->user();

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
        $user = Auth::guard('admin')->user();

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
            Storage::disk('public')->delete($old_image);
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
        $this->authorize('viewTrash', Product::class);
        $request = request();

        $products = Product::onlyTrashed()
            ->filter($request->query())
            ->paginate();

        return view('dashboard.products.trash', compact('products'));
    }

    public function restore(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $product);

        $product->restore();

        return redirect()->route('dashboard.products.trash')
            ->with('info', 'Product Restored Successfully!');
    }

    public function forceDelete(int $id)
    {
        $product = Product::onlyTrashed() -> findOrFail($id);

        $this->authorize('forceDelete', $product);

        $product->forceDelete();

        // to delete the image from the storage/app/public file
        if($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return redirect()->route('dashboard.products.trash')
            ->with('delete', 'Product Deleted Forever!');
    }

    public function deleteImage(Product $product)
    {
        $this->authorize('update', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);

            $product->update(['image' => null]);
        }

        return redirect()
            ->back()
            ->with('info', 'Product Image Deleted Successfully');
    }
}
