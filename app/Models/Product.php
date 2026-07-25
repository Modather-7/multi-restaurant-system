<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

#[Fillable([
    'name', 'slug', 'category_id', 'restaurant_id', 'ingredients',
    'price', 'compare_price', 'image', 'status', 'feautured'
])]
#[Hidden(['image', 'created_at', 'updated_at', 'deleted_at'])]
#[Appends(['image_url'])]
class Product extends Model
{
    use HasFactory, SoftDeletes;
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
            if ($user && $user->restaurant_id) {
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
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_products')
            ->withPivot('availability')
            ->withTimestamps();
    }

    public function branchProducts()
    {
        return $this->hasMany(BranchProduct::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

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

        $options = array_merge([
            'restaurant_id' => null,
            'category_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['restaurant_id'], function ($builder, $value) {
            $builder->where('restaurant_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });

        $builder->when($options['status'], function ($builder, $value) {
            $builder->where('status', $value);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getImageUrlAttribute()
    {
        if( ! $this->image){
            return 'https://cdn.vectorstock.com/i/500p/44/96/silver-dome-food-cover-vector-63084496.jpg';
        }

        if(Str::startsWith($this->image, ['http://', 'https://'])){
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if( ! $this->compare_price){
            return 0;
        }
        return 100 - (100 * $this->compare_price / $this->price);
    }

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
