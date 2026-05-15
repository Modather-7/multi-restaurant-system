<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'restaurant_id',
        'ingredients',
        'price',
        'compare_price',
        'quantity',
        'image',
        'status',
        'feautured',
    ];

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
    public function branchProducts()
    {
        return $this -> hasMany(BranchProduct::class);
    }

    public function cartItems()
    {
        return $this -> hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this -> hasMany(OrderItem::class);
    }

    public function branches()
    {
        return $this -> belongsToMany(Branch::class)
            ->withPivot('quantity');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // model initialization
    protected static function booted()
    {
        // restaurant_id -> authentication
        static::addGlobalScope('restaurant', function(Builder $builder) {
            $user = Auth::user();
            if ($user->restaurant_id) {
                $builder->where('restaurant_id', $user->restaurant_id);
            }
        });

        // slug
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // dynamic scope
    public function scopeFilter(Builder $builder, array $filters)
    {
        $builder->when($filters['name'] ?? false, function($builder, $value) {
            $builder->where('name', 'LIKE', "%{$value}%");
        });

        // use ($filters) -> means active, draft or achived as it comes from $filters['status'],
        $builder->when(
            isset($filters['status']) && $filters['status'] != 'All',
            function($builder) use ($filters) {
                $builder->where('status', $filters['status']);
        });
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
