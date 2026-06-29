<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Branch;
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
    public function create(CartRepository $cart, Restaurant $restaurant, Branch $branch)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('restaurant.menu.index', [$restaurant, $branch]);
        }

        $areas = DeliveryArea::where('branch_id', $branch->id)->get();

        return view('front.checkout', compact('cart', 'areas', 'restaurant', 'branch', 'areas'));
    }

    public function store(Request $request, CartRepository $cart, Restaurant $restaurant, Branch $branch)
    {
        $cartItems = $cart->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('restaurant.menu.index', [$restaurant, $branch]);
        }

        $request->validate([
        ]);

        $restaurant_id = $cartItems->first()->product->restaurant_id;

        DB::beginTransaction(); // Cancel auto commit
        try {
            $order = Order::create([
                'restaurant_id' => $restaurant_id,
                'branch_id' => $branch->id,
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

            DB::commit(); // after successful transaction commit the order

            OrderCreated::dispatch($order, request()->cookie('cart_id')); // OrderCreated event construct

        } catch(Throwable $e) { // Throwable::class ---> any throwable exception
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('restaurant.home', $restaurant);
    }
}
