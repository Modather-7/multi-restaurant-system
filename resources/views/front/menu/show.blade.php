<x-front-layout :title="$product->name">

    <section class="product-details-section py-5 dots-bg">
        <div class="container">
            <div class="product-wrapper bg-white rounded-5 shadow-sm overflow-hidden">
                <div class="row g-0 align-items-stretch">

                    {{-- Product Image --}}
                    <div class="col-lg-6">
                        <div class="image-side h-100 p-4 p-lg-5 d-flex flex-column justify-content-center">
                            <div class="product-image-wrapper position-relative mx-auto">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-main-image">
                                {{-- Badges --}}
                                <div class="position-absolute top-0 start-0 d-flex gap-2 p-3">

                                    @if ($product->new)
                                        <span class="custom-badge success">
                                            {{ trans('New') }}
                                        </span>
                                    @endif

                                    @if ($product->sale_percent)
                                        <span class="custom-badge danger">
                                            -{{ round($product->sale_percent) }}%
                                        </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div class="col-lg-6">
                        <div class="info-side p-4 p-lg-5 h-100 d-flex flex-column">
                            {{-- Breadcrumb --}}
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb mb-0 small">
                                    <li class="breadcrumb-item">
                                        <a href="{{  route('restaurant.menu.index', [$restaurant, $branch])  }}" class="text-decoration-none">
                                            {{ trans('Menu') }}
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{ $product->category->name }}
                                    </li>
                                </ol>
                            </nav>

                            {{-- Title --}}
                            <h1 class="product-title">
                                {{ $product->name }}
                            </h1>
                            {{-- Price --}}
                            <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
                                @if ($product->compare_price)
                                <span class="current-price">
                                    {{ App\Helpers\Currency::format($product->compare_price) }}
                                </span>

                                    <span class="old-price">
                                        {{ App\Helpers\Currency::format($product->price) }}
                                    </span>
                                @else
                                    <span class="current-price">
                                        {{ App\Helpers\Currency::format($product->price) }}
                                    </span>
                                @endif
                            </div>

                            {{-- Description --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    {{ trans('Description') }}
                                </label>

                                <p class="description-text mb-0">
                                    {{ $product->ingredients }}
                                </p>
                            </div>

                            {{-- Form --}}
                            <form action="{{ route('restaurant.cart.store', [$restaurant, $branch]) }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                {{-- Notes --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        {{ trans('Special Instructions') }}
                                    </label>
                                    <textarea
                                        name="notes"
                                        rows="3"
                                        class="form-control modern-input @error('notes') is-invalid @enderror"
                                        placeholder="{{ trans('Add notes, allergies...') }}"></textarea>

                                    @error('notes')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Actions --}}
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    {{-- Quantity --}}
                                    <div class="qty-box">
                                        <button type="button" onclick="changeQty(-1)">
                                            -
                                        </button>
                                        <input type="text" id="qty-input" name="quantity" value="1" readonly>
                                        <button type="button" onclick="changeQty(1)">
                                            +
                                        </button>
                                    </div>

                                    {{-- Add To Cart --}}
                                    <button type="submit" class="btn add-cart-btn flex-grow-1" onclick="this.disabled=true; this.form.submit();">
                                        <i class="lni lni-cart-full me-2"></i>
                                        {{ trans('Add To Cart') }}
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function changeQty(amount) {

                const qtyInput = document.getElementById('qty-input');

                let current = parseInt(qtyInput.value);

                current += amount;

                if (current < 1) {
                    current = 1;
                }

                qtyInput.value = current;
            }
        </script>
    @endpush

</x-front-layout>
