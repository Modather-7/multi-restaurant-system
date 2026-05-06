<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();

        $categories = Category::filter($request->query())
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        return view('dashboard.categories.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('dashboard.categories.index')
        ->with('success', 'Category Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category->fill($validated);
        $hasChanges = $category->isDirty();

        if(! $hasChanges){
            return redirect()->route('dashboard.categories.index')
            ->with('info', 'No Changes Were Made');
        }
        $category->save($validated);

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
        $request = request();

        $categories = Category::onlyTrashed()
            ->filter($request->query())
            ->paginate();

        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('info', 'Category Restored Successfully!');
    }

    public function forceDelete(int $id)
    {
        $category = Category::onlyTrashed() -> findOrFail($id);
        $category->forceDelete();

        return redirect()->route('dashboard.categories.trash')
            ->with('delete', 'Category Deleted Forever!');
    }
}
