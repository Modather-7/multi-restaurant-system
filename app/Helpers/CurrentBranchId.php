<?php

namespace App\Helpers;

class CurrentBranchId
{
    public static function getBranchId()
    {
        return request()->cookie('res_' . request()->route('restaurant')->id . '_branch'); // restaurant_restaurantId_branch->value(encrypted)
    }
}
