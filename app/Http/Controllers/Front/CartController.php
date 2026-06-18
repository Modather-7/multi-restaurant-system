<?php

namespace App\Http\Controllers\Front;

use App\Helpers\CurrentBranchId;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CartRequest;
use App\Models\Branch;
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
    public function index(Restaurant $restaurant, Branch $branch)
    {
        return view('front.cart.index', [
            'cart' => $this->cart,
            'restaurant' => $restaurant,
            'branch' => $branch,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request, Restaurant $restaurant, CartRepository $cart)
    {
        $branchId = CurrentBranchId::getBranchId();

        if (! $branchId) {
            return redirect()->route('restaurant.branches', $restaurant);
        }

        $branch = Branch::findOrFail($branchId);

        $product = Product::findOrFail($request->post('product_id'));

        if ($product->restaurant_id !== $restaurant->id) {
            abort(403);
        }

        $cart->add($product, $request->post('quantity'), $request->post('notes'));

        if($request->expectsJson()){
            return response()->json([
                'Item added to cart successfully',
            ], 201); // success and created
        }
        return redirect()->route('restaurant.cart.index', [$restaurant, $branch]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant, Branch $branch, Cart $cart)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        $this->cart->update($cart->id, $request->quantity);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Branch $branch, Cart $cart)
    {
        $this->cart->delete($cart->id);

        return [
            'message' => 'Item deleted!',
        ];
    }
}
