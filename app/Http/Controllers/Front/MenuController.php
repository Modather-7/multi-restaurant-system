<?php

namespace App\Http\Controllers\Front;

use App\Helpers\CurrentBranchId;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Restaurant;

class MenuController extends Controller
{
    public function index(Restaurant $restaurant, Branch $branch)
    {
        $branchId = CurrentBranchId::getBranchId();

        if (! $branchId) {
            return redirect()->route('restaurant.branches', $restaurant);
        }
        
        $categories = $restaurant->categories()
            ->withWhereHas('products', function ($query) use ($restaurant, $branchId) {

                $query->where('restaurant_id', $restaurant->id)
                    ->where('status', 'active')
                    ->whereHas('branches', function ($q) use ($branchId) {

                        $q->where('branches.id', $branchId)
                            ->where('availability', 'available');

                    });

            })
            ->latest('id')
            ->get();

        return view('front.menu.index', compact('categories', 'restaurant', 'branch'));
    }

    public function show(Restaurant $restaurant, Branch $branch, Product $product)
    {
        if($product->status != 'active'){
            abort(404);
        }

        if ($product->restaurant_id != $restaurant->id) {
            abort(404);
        }

        return view('front.menu.show', compact('restaurant', 'branch', 'product'));
    }
}
