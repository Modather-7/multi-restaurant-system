<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'name',
        'category_id',
        'ingredients',
        'price',
        'quantity',
        'image',
        'is_available',
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
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */

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
    // local scope
    public function scopeActive(Builder $builder)
    {
        $builder->where('is_available', '=', 1);
    }

    // dynamic scope
    public function scopeFilter(Builder $builder, array $filters)
    {
        $builder->when($filters['name'] ?? false, function($builder, $value) {
            $builder->where('name', 'LIKE', "%{$value}%");
        });

        // use ($filters) -> means true or false as it comes from $filters['is_available'],
        // I didn't use $value as the want 0,1 value not true,false or string
        $builder->when(
            isset($filters['is_available']) && $filters['is_available'] != 'All',
            function($builder) use ($filters) {
                $builder->where('is_available', $filters['is_available']);
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
