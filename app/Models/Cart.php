<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

#[Fillable(['cookie_id', 'user_id', 'product_id', 'restaurant_id', 'branch_id', 'notes', 'quantity', 'options'])]
class Cart extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public $incrementing = false;
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
    public static function getCookieId()
    {
        $minutes = 60*24*30;
        $cookie_id = Cookie::get('cart_id');
        if(!$cookie_id){
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, $minutes); // expiry date
        }
        return $cookie_id;
    }

    // Cart Events (Observers)
	// Creating, Created, Updating, Updated, Saving, Saved
	// Deleting, Deleted, Restoring, Restored, Retrieved
    protected static function booted()
    {
        static::observe(CartObserver::class);

        static::addGlobalScope('cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', '=', Cart::getCookieId());
        });

        // static::creating(function(Cart $cart){
        //     $cart->id = Str::uuid();
        // });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this -> belongsTo(User::class)->withDefault([
            'name' => 'Anonymous',
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeForRestaurant(Builder $builder)
    {
        $restaurant = request()->route('restaurant');

        abort_if(!$restaurant, 404);

        return $builder->where('restaurant_id', $restaurant->id);
    }

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
