<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'delivery_area_id', 'full_name', 'email', 'phone_number', 'notes', 'street_address'])]
class OrderAddress extends Model
{
    public $timestamps = false;
}
