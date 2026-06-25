<?php

namespace App\Helpers;

use App\Models\Cart;

class CartCounter
{
    public static function count()
    {
        return Cart::where('cookie_id', request()->cookie('cart_id'))
            ->forRestaurant()
            ->forBranch()
            ->sum('quantity');
    }
}
