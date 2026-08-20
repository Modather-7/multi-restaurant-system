<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CheckoutRequest;
use App\Models\Branch;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart, Restaurant $restaurant, Branch $branch)
    {
        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException(trans('Cart is empty!'));
        }

        $areas = DeliveryArea::where('branch_id', $branch->id)->get();

        return view('front.checkout', compact('cart', 'restaurant', 'branch', 'areas'));
    }

    public function store(CheckoutRequest $request, CartRepository $cart, Restaurant $restaurant, Branch $branch)
    {
        $cartItems = $cart->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('restaurant.menu.index', [$restaurant, $branch]);
        }

        $validated = $request->validated();

        $restaurant_id = $cartItems->first()->product->restaurant_id;

        DB::beginTransaction(); // Cancel auto commit
        try {
            $order = Order::create([
                'restaurant_id' => $restaurant_id,
                'branch_id' => $branch->id,
                'order_type' => $validated['order_type'],
                'user_id' => Auth::id(),

                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],

                'payment_method' => 'COD',
            ]);

            if ($validated['order_type'] === 'delivery') {
                $order->address()->create([
                    'delivery_area_id' => $validated['delivery_area_id'],
                    'street_address' => $validated['street_address'],
                ]);
            }

            foreach ($cartItems as $item) { // get(): collection returns cart items
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'notes' => $item->notes,
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
