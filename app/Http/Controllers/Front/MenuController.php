<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Restaurant;

class MenuController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $categories = $restaurant->categories()->with([
            'products' => function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id)
                    ->where('status', 'active');
            }
        ])->latest('id')->get();

        return view('front.menu.index', compact('categories', 'restaurant'));
    }

    public function show(Restaurant $restaurant, Product $product)
    {
        if($product->status != 'active'){
            abort(404);
        }

        if ($product->restaurant_id != $restaurant->id) {
            abort(404);
        }

        return view('front.menu.show', compact('product', 'restaurant'));
    }
}
