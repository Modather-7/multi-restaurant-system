<x-front-layout :title="$product->name">

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">

                {{-- Image --}}
                <div class="col-lg-6 text-center">

                    {{-- Back Button --}}
                    <div class="text-start mb-3">
                        <button
                            onclick="history.back()"
                            class="btn btn-light rounded-pill px-4 shadow-sm">
                            ← Back
                        </button>
                    </div>

                    <div class="position-relative">
                        <img src="{{ $product->image_url }}"
                             class="img-fluid rounded-4 shadow-lg w-100"
                             style="max-height: 500px; object-fit: cover;"
                             alt="{{ $product->name }}">

                        @if ($product->compare_price)
                            <span class="badge rounded-pill bg-success position-absolute top-0 start-0 m-3 px-3 py-2 shadow-sm">
                                -{{ round($product->sale_percent) }}%
                            </span>
                        @endif
                    </div>

                </div>

                {{-- Details --}}
                <div class="col-lg-6">

                    {{-- Breadcrumb --}}
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item">
                                <a href="/menu" class="text-muted text-decoration-none">
                                    Menu
                                </a>
                            </li>

                            <li class="breadcrumb-item active text-dark">
                                {{ $product->category->name }}
                            </li>
                        </ol>
                    </nav>

                    {{-- Name --}}
                    <h1 class="fw-bold text-dark display-5 mb-2">
                        {{ $product->name }}
                    </h1>

                    {{-- Price --}}
                    <div class="mb-4">
                        @if ($product->compare_price)
                            <div class="text-muted text-decoration-line-through small mb-1">
                                {{ $product->compare_price }} EGP
                            </div>
                        @endif

                        <h2 class="text-gold fw-bold mb-0">
                            {{ $product->price }}
                            <span class="fs-5 text-muted">EGP</span>
                        </h2>
                    </div>

                    {{-- Ingredients --}}
                    <p class="text-muted fs-5 mb-4">
                        {{ $product->ingredients }}
                    </p>

                    {{-- Notes --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Notes
                        </label>

                        <textarea
                            id="cart-note"
                            class="form-control rounded-3"
                            rows="3"
                            placeholder="Extra cheese, no onions..."></textarea>
                    </div>

                    {{-- Qty + Cart --}}
                    <div class="d-flex flex-column flex-sm-row gap-3 align-items-start align-items-sm-center">

                        {{-- Quantity --}}
                        <div class="d-inline-flex align-items-center border rounded-3 overflow-hidden">
                            <button
                                type="button"
                                class="btn px-3 py-2"
                                style="background: #f8f9fa;"
                                onclick="changeQty(-1)">
                                <span class="fw-bold fs-4">−</span>
                            </button>

                            <input
                                type="text"
                                id="detail-qty"
                                value="1"
                                readonly
                                class="form-control text-center border-0 shadow-none"
                                style="width: 55px; font-weight: 600; flex: unset;">

                            <button
                                type="button"
                                class="btn px-3 py-2"
                                style="background: #f8f9fa;"
                                onclick="changeQty(1)">
                                <span class="fw-bold fs-4">+</span>
                            </button>
                        </div>

                        {{-- Add To Cart --}}
                        <button
                            class="btn btn-gold btn-lg px-4 shadow-sm w-50 w-sm-auto"
                            onclick="CartEngine.addToCart(
                                {{ $product->id }},
                                document.getElementById('detail-qty').value,
                                document.getElementById('cart-note').value
                            )">
                            Add To Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function changeQty(amount) {

            let qtyInput = document.getElementById('detail-qty');

            let current = parseInt(qtyInput.value);

            current += amount;

            if (current < 1) {
                current = 1;
            }

            qtyInput.value = current;
        }
    </script>

</x-front-layout>
