<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CurrentBranchId;

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
        $branchId = CurrentBranchId::getBranchId();

        if (! $branchId) {
           abort(403, 'Branch not selected');
        }

        $item = Cart::where('product_id', $product->id)
                ->where('branch_id', CurrentBranchId::getBranchId())
                ->where('cookie_id', request()->cookie('cart_id'))
                ->first();

        if(! $item){
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'restaurant_id' => $product->restaurant_id,
                'branch_id' => $branchId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'notes' => $notes,
            ]);
            $this->get()->push($cart);
            return $cart;
        }

        $item->increment('quantity', $quantity);

        if ($notes) {
            $item->update(['notes' => $notes]);
        }

        return $item;
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
