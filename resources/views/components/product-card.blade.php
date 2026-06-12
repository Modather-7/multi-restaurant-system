<div class="single-product">
    <div class="product-image">
        <a href="{{ route('restaurant.menu.show', [$product->restaurant, $product->slug]) }}">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        </a>

        @if($product->sale_percent)
            <span class="sale-tag">-{{ round($product->sale_percent) }}%</span>
        @endif
        @if($product->new)
            <span class="new-tag">New</span>
        @endif

        <div class="button">
            <a href="{{ route('restaurant.menu.show', [$product->restaurant, $product->slug]) }}" class="btn">
                <i class="lni lni-cart"></i> View Details
            </a>
        </div>
    </div>

    <div class="product-info">
        <h4 class="title">
            <a href="{{ route('restaurant.menu.show', [$product->restaurant, $product->slug]) }}">{{ $product->name }}</a>
        </h4>

        <p class="text-muted small mb-2" style="min-height: 40px;">
            {{ Str::limit($product->ingredients, 45) }}
        </p>

        <div class="price">
            <span>
                {{ App\Helpers\Currency::format($product->compare_price ?? $product->price) }}
            </span>

            @if($product->compare_price && $product->compare_price < $product->price)
                <span class="discount-price"
                    style="text-decoration: line-through; color: #999; font-size: 14px; margin-left: 10px;">
                    {{ App\Helpers\Currency::format($product->price) }}
                </span>
            @endif
        </div>
    </div>
</div>
