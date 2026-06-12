<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart, Restaurant $restaurant)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('restaurant.home');
        }

        $areas = DeliveryArea::where('branch_id', session('branch_id'))->get();

        return view('front.checkout', compact('cart', 'areas', 'restaurant'));
    }

    public function store(Request $request, CartRepository $cart)
    {
        $cartItems = $cart->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('restaurant.home');
        }

        $request->validate([
        ]);

        $restaurant_id = $cartItems->first()->product->restaurant_id;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'restaurant_id' => $restaurant_id,
                'branch_id' => session('branch_id'),
                'order_type' => $request->order_type,
                'user_id' => Auth::id(),
                'payment_method' => 'COD',
            ]);

            if ($request->order_type === 'delivery') {
                $order->address()->create([
                    'delivery_area_id' => $request->delivery_area_id,
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'notes' => $request->notes,
                    'street_address' => $request->street_address,
                ]);
            }

            foreach ($cartItems as $item) { // get(): collection returns cart items
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity
                ]);
            }

            $cart->empty(); // after completing the order remove the cart

            DB::commit();

        } catch(Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('restaurant.home');
    }
}
