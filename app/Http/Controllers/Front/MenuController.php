<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::active()
            ->latest()
            ->take(6)
            ->get();
        $categories = Category::latest('id')
            ->take(6)
            ->get();

        return view('front.menu.index', compact('products', 'categories'));
    }

    public function show(Product $product, Category $category)
    {
        if($product->status != 'active'){
            abort(404);
        }

        return view('front.menu.show', compact('product','category'));
    }
}
