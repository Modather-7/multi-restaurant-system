<?php

namespace App\Http\Controllers\Front;

use App\Helpers\CurrentBranchId;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $branches = $restaurant->branches()
            ->where('status', 'active')
            ->get();

        return view('front.branch', compact('restaurant', 'branches'));
    }

    public function select(Restaurant $restaurant, Branch $branch)
    {
        $branch = $restaurant->branches()->where('status', 'active')->findOrFail($branch->id);
        $currentBranch = CurrentBranchId::getBranchId();

        if ($currentBranch && $currentBranch != $branch->id) {
            Cart::where('cookie_id', request()->cookie('cart_id'))
                ->where('restaurant_id', $restaurant->id)
                ->delete();
        } // delete the cart after customer change branch

        Cookie::queue("res_{$restaurant->id}_branch", $branch->id, 60*24*30);

        return redirect()->route('restaurant.menu.index', [$restaurant, $branch]);
    }
}
