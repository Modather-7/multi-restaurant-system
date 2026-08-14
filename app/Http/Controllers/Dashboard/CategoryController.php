<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();

        $categories = Category::filter($request->query())
            ->with('restaurant')
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $user = Auth::guard('admin')->user();
        $restaurants = $user->restaurant();

        return view('dashboard.categories.create', compact('category', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('dashboard.categories.index')
        ->with('success', 'Category Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $user = Auth::guard('admin')->user();
        $restaurants = $user->restaurant();

        return view('dashboard.categories.edit', compact('category', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $old_image = $category->image;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->fill($validated);

        $hasChanges = $category->isDirty();

        if(! $hasChanges){
            return redirect()->route('dashboard.categories.index')
            ->with('info', 'No Changes Were Made');
        }

        $category->save();

        // delete the old image
        if($request->hasFile('image') && $old_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')
        ->with('info', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('dashboard.categories.index')
            ->with('delete', 'Category Trashed!');
    }

    public function trash()
    {
        $this->authorize('viewTrash', Category::class);

        $request = request();

        $categories = Category::onlyTrashed()
            ->filter($request->query())
            ->paginate();

        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $category);

        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('info', 'Category Restored Successfully!');
    }

    public function forceDelete(int $id)
    {
        $category = Category::onlyTrashed() -> findOrFail($id);

        $this->authorize('forceDelete', $category);

        $category->forceDelete();

        // to delete the image from the storage/app/public file
        if($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('delete', 'Category Deleted Forever!');
    }

    public function deleteImage(Category $category)
    {
        $this->authorize('update', $category);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);

            $category->update(['image' => null]);
        }

        return redirect()
            ->back()
            ->with('info', 'Category Image Deleted Successfully');
    }
}
