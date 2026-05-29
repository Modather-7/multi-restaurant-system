<x-front-layout title="Cart">

    <section class="cart-page">
        <div class="container">

            {{-- HEADER --}}
            <div class="cart-header">
                <div>
                    <h1>Your Cart</h1>
                    <p>Review your selected meals before checkout</p>
                </div>

                <a href="/menu" class="continue-shopping">
                    Continue Shopping
                </a>
            </div>
            <div class="row g-4">

                {{-- CART ITEMS --}}
                <div class="col-lg-8">
                    <div class="cart-card">
                        @foreach ($cart->get() as $item)
                            <div class="cart-item" id="{{ $item->id }}">
                                {{-- IMAGE --}}

                                <div class="cart-item-image">
                                    <img src="{{ $item->product->image_url }}" alt="">
                                </div>

                                {{-- INFO --}}
                                <div class="cart-item-info">
                                    <h5>
                                        <a href="{{ route('menu.show', $item->product->slug) }}">
                                            {{ $item->product->name }}
                                        </a>
                                    </h5>

                                    <div class="cart-item-meta">
                                        {{ $item->product->category->name }}
                                    </div>

                                    <div class="cart-item-price">
                                        @if ($item->product->compare_price)
                                            <span class="current-price">
                                                {{ App\Helpers\Currency::format($item->product->compare_price) }}
                                            </span>
                                            <span class="old-price">
                                                {{ App\Helpers\Currency::format($item->product->price) }}
                                            </span>
                                        @else
                                            <span class="current-price">
                                                {{ App\Helpers\Currency::format($item->product->price) }}
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                {{-- QUANTITY --}}
                                <div class="cart-quantity">
                                    <button>-</button>
                                    <input type="text" value="{{ $item->quantity }}" class="item-quantity"
                                        data-id="{{ $item->id }}" readonly>
                                    <button>+</button>
                                </div>

                                {{-- TOTAL --}}
                                <div class="cart-total">
                                    {{ App\Helpers\Currency::format($item->quantity * ($item->product->compare_price ?: $item->product->price)) }}
                                </div>

                                {{-- REMOVE --}}
                                <div class="cart-remove">
                                    <a href="javascript:void(0)" class="remove-item" data-id="{{ $item->id }}">
                                        <i class="lni lni-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- SUMMARY --}}
                <div class="col-lg-4">

                    <div class="summary-card">
                        <h4>Order Summary</h4>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>{{ App\Helpers\Currency::format($cart->total()) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery</span>
                            <span>Free</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>{{ App\Helpers\Currency::format($cart->total()) }}</span>
                        </div>
                        <button class="checkout-btn">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            {{-- END CART ITEMS --}}
            </div>
        </div>
    </section>

</x-front-layout>
