<x-front-layout title="Checkout">

<form action="{{ route('restaurant.checkout', [$restaurant, $branch]) }}" method="POST">
    @csrf

    <div class="checkout-page">
        <div class="container">
            <div class="row g-4">

                {{-- LEFT --}}
                <div class="col-lg-7">

                    {{-- ORDER TYPE --}}
                    <div class="checkout-card">

                        <h4 class="checkout-title">Order Type</h4>

                        <div class="d-flex gap-3">

                            <label class="payment-option w-100">
                                <input type="radio" name="order_type" value="delivery" checked>
                                <span>Delivery</span>
                            </label>

                            <label class="payment-option w-100">
                                <input type="radio" name="order_type" value="pickup">
                                <span>Pickup</span>
                            </label>

                        </div>

                    </div>

                    {{-- DELIVERY --}}
                    <div id="delivery-box" class="checkout-card mt-4">

                        <h4 class="checkout-title">Delivery Details</h4>

                        <div class="mb-3">
                            <label>Area</label>
                            <select name="delivery_area_id" class="form-control">
                                <option value="">Select Area</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}">
                                        {{ App\Helpers\Currency::format($area->delivery_fee) }} - {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label>Street Address</label>
                            <textarea name="street_address" rows="3" class="form-control"></textarea>
                        </div>

                    </div>

                    {{-- CUSTOMER INFO --}}
                    <div class="checkout-card mt-4">

                        <h4 class="checkout-title">Customer Info</h4>

                        <input type="text" name="full_name" class="form-control mb-2" placeholder="Full Name">

                        <input type="text" name="phone_number" class="form-control mb-2" placeholder="Phone">

                        <input type="email" name="email" class="form-control" placeholder="Email (optional)">

                    </div>

                    {{-- PAYMENT --}}
                    <div class="checkout-card mt-4">

                        <h4 class="checkout-title">Payment Method</h4>

                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span>💵 Cash</span>
                        </label>

                        <label class="payment-option mt-2 opacity-50">
                            <input type="radio" disabled>
                            <span>💳 Online Payment (Coming Soon)</span>
                        </label>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="col-lg-5">

                    <div class="checkout-card sticky-top">

                        <h4 class="checkout-title">Order Summary</h4>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>{{ App\Helpers\Currency::format($cart->total()) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Delivery</span>
                            <span id="delivery-fee">{{ App\Helpers\Currency::format(0) }}</span>
                        </div>

                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="total-price">
                                {{ App\Helpers\Currency::format($cart->total()) }}
                            </span>
                        </div>

                        <button type="submit" class="checkout-btn">
                            Place Order
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

@push('scripts')
        @vite(['resources/js/checkout.js'])
@endpush

</x-front-layout>
