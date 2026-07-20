<x-front-layout title="Cart">

    <section class="cart-page dots-bg">
        <div class="container">
            <div class="row g-4" id="cart-wrapper">

                @if ($cart->get()->isEmpty())
                    <div class="col-lg-8 mx-auto">
                        @include('front.cart._empty')
                    </div>
                @else

                    {{-- HEADER --}}
                    <div id="cart-header">
                        <div class="cart-header">
                            <div>
                                <h1>Your Cart</h1>
                                <p>
                                    Review your selected meals and checkout or
                                    <a href="{{ route('restaurant.menu.index', [$restaurant, $branch]) }}"
                                    class="continue-shopping">
                                        Continue Shopping
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- CART ITEMS --}}
                    <div class="col-lg-8">

                        <div class="cart-card">

                            @foreach ($cart->get() as $item)
                                <div class="cart-item"
                                    id="{{ $item->id }}"
                                    data-price="{{ $item->product->compare_price ?: $item->product->price }}">

                                    {{-- IMAGE --}}
                                    <div class="cart-item-image">
                                        <img src="{{ $item->product->image_url }}" alt="">
                                    </div>

                                    {{-- INFO --}}
                                    <div class="cart-item-info">
                                        <h5>
                                            <a href="{{ route('restaurant.menu.show', [$restaurant, $branch, $item->product->slug]) }}">
                                                {{ $item->product->name }}
                                            </a>
                                        </h5>

                                        <div class="cart-item-notes">
                                            @if ($item->notes)
                                                <span class="notes">( {{ $item->notes }} )</span>
                                            @endif
                                        </div>

                                    </div>

                                    {{-- QUANTITY --}}
                                    <div class="cart-quantity">
                                        <button type="button" class="qty-minus">-</button>

                                        <input type="text"
                                            value="{{ $item->quantity }}"
                                            class="item-quantity"
                                            data-id="{{ $item->id }}"
                                            readonly>

                                        <button type="button" class="qty-plus">+</button>
                                    </div>

                                    {{-- TOTAL --}}
                                    <div class="cart-total">
                                        {{ App\Helpers\Currency::format($item->quantity * ($item->product->compare_price ?: $item->product->price)) }}
                                    </div>

                                    {{-- REMOVE --}}
                                    <div class="cart-remove">
                                        <button type="button" class="remove-item" data-id="{{ $item->id }}">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
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

                            <a href="{{ route('restaurant.checkout', [$restaurant, $branch]) }}">
                                <button class="checkout-btn">
                                    Proceed to Checkout
                                </button>
                            </a>

                        </div>

                    </div>

                @endif
                {{-- END CART ITEMS --}}

            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        @vite(['resources/js/cart.js'])

        <script type="text/template" id="empty-cart-template">
            @include('front.cart._empty')
        </script>

        <script>
            const restaurant_slug = "{{ $restaurant->slug }}";
            const branch_slug = "{{ $branch->name }}";
            const csrf_token = "{{ csrf_token() }}";
        </script>
    @endpush

</x-front-layout>
