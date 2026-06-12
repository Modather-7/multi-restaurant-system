<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartModelRepository implements CartRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function get(): Collection
    {
        if(!$this->items->count()){
            $this->items = Cart::with('product')->get();
        }

        return $this->items;
    }

    public function add(Product $product, $quantity = 1, $notes = null)
    {
        $item = Cart::where('product_id', $product->id)
            ->first();

        if(! $item){
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'restaurant_id' => $product->restaurant_id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'notes' => $notes,
            ]);
            $this->get()->push($cart);
            return $cart;
        }

        return $item->increment('quantity', $quantity, ['notes' => $notes]);
    }

    public function update($id, $quantity)
    {
        Cart::where('id',$id)
            ->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id)
    {
        Cart::where('id', $id)
            ->delete();
    }

    public function empty()
    {
        Cart::query()->delete(); // returns query builder for Cart Model
    }

    public function total(): float
    {
        // return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
        //     ->selectRaw('SUM(carts.quantity * COALESCE(products.compare_price, products.price)) as total')
        //     ->value('total');

        return $this->get()->sum(function ($item) {
            if($item->product->compare_price){
                return $item->quantity * $item->product->compare_price;
            } else {
                return $item->quantity * $item->product->price;
            }
        });
    }
}
