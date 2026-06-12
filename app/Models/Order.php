<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'restaurant_id', 'status', 'payment_method', 'payment_status', 'order_type'])]
class Order extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | CONFIGURATION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function getNextOrderNumber()
    {
        // SELECT MAX(number) FROM orders
        $year = Carbon::now()->year();
        $number = Order::whereYear('created_at', $year)->max('number');

        if($number){
            return $number + 1;
        }
        return $year . '001';
    }

    protected static function booted()
    {
        static::creating(function(Order $order) {
            // 20260001, 20260002, 20260003 -> year . order number
            $order->number = Order::getNextOrderNumber();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this -> belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }

    public function restaurant()
    {
        return $this -> belongsTo(Restaurant::class);
    }

    public function products()
    {
        return $this -> belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class) // to make using() OrderItem class must extend Pivot not Model
            ->withPivot([
                'product_name', 'price', 'quantity', 'notes', 'options'
            ]);
    }

    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | TESTING
    |--------------------------------------------------------------------------
    */

}
