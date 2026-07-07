<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'delivery_area_id', 'street_address'])]
class OrderAddress extends Model
{
    public $timestamps = false;
}
