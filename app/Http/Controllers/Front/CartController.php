<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Restaurant;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        return view('front.cart.index', [
            'cart' => $this->cart,
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request, CartRepository $cart)
    {
        $product = Product::findOrFail($request->post('product_id'));
        $restaurant = $product->restaurant;
        $cart->add($product, $request->post('quantity'), $request->post('notes'));

        if($request->expectsJson()){
            return response()->json([
                'Item added to cart successfully',
            ], 201); // success and created
        }
        return redirect()->route('restaurant.cart.index', $restaurant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant, Cart $cart)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:50']
        ]);

        $this->cart->update($cart->id, $request->quantity);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Cart $cart)
    {
        $this->cart->delete($cart->id);

        return [
            'message' => 'Item deleted!',
        ];
    }
}
