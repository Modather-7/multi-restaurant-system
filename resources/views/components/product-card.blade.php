<div class="col-md-6 col-lg-4 product-item-card" data-category="{{ $product->category_id }}">
    <div class="product-card bg-white">
        <div class="position-relative overflow-hidden">
            <a href="{{ route('menu.show', $product->slug) }}">
                <img src="{{ $product->image_url }}"
                class="card-img-top product-image"
                alt="{{ $product->name }}">
            </a>
            @if ($product->sale_percent)
                <div class="position-absolute top-0 start-0 m-3">
                    <span class="discount-badge bg-success rounded-pill text-white top-0 start-0 m-2 px-3 py-2">
                        -{{ round($product->sale_percent) }}%
                    </span>
                </div>
            @endif
            @if ($product->new)
                <div class="position-absolute top-0 start-0 m-3">
                    <span class="new-tag bg-success rounded-pill text-white top-0 start-0 m-2 px-3 py-2">
                        New
                    </span>
                </div>
            @endif
        </div>

        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-success small fw-semibold">● Available</span>
            </div>
            <h5 class="fw-bold text-dark mb-2">{{ $product->name }}</h5>
            <p class="text-muted small mb-4" style="min-height: 40px;">{{ $product->ingredients }}</p>
            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <div>
                    {{-- Old Price --}}
                    @if ($product->compare_price)
                        <div class="text-muted small text-decoration-line-through">
                            {{ App\Helpers\Currency::format($product->compare_price) }}
                        </div>
                    @endif
                    {{-- Current Price + Discount --}}
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold fs-4 text-dark">
                            {{ App\Helpers\Currency::format($product->price) }}
                        </span>

                    </div>
                </div>
                <button onclick="CartEngine.addToCart({{ $product->id }}, 1)"
                    class="btn btn-dark btn-sm px-3 rounded-2">
                    Add To Cart
                </button>
            </div>
        </div>
    </div>
</div>
