<x-front-layout title="Our Fine Menu">

    {{-- HERO + CATEGORIES --}}
    <section class="menu-hero-section dots-bg">
        <div class="container">
            <div class="menu-hero-content text-center">
                <h1 class="menu-title">
                    Our Menu
                </h1>
            </div>
            <div class="menu-categories-wrapper">
                <ul class="nav justify-content-center gap-2 flex-wrap" id="menu-tabs">

                    {{-- CATEGORIES --}}
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <button class="nav-link" data-target="cat-{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- PRODUCTS --}}
    <section class="menu-products-section dots-bg">
        <div class="container">

            <div class="menu-banner-top">
                <img
                    src="{{ asset('storage/' . $categories->first()->image) }}"
                    alt="{{ $categories->first()->name }}"
                >
            </div>

            @foreach ($categories as $category)
                @if ($category->products->count())

                    {{-- CATEGORY BLOCK --}}
                    <div class="category-block mb-5" id="cat-{{ $category->id }}">
                        {{-- TITLE --}}
                        <div class="mb-4">
                            <h3 class="fw-italic text-dark mb-1">
                                {{ $category->name }}
                            </h3>
                        </div>

                        {{-- PRODUCTS --}}
                        <div class="row">
                            @foreach ($category->products as $product)
                                <div class="col-lg-3 col-md-4 col-6 mb-3">
                                    <div class="product-card-animation">
                                            <x-product-card
                                                :product="$product"
                                                :branch="request()->route('branch')"
                                            />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Banner Between Categories --}}
                    @if (!$loop->last && $categories[$loop->index + 1]->image)

                        <div class="menu-banner-between">
                            <img
                                src="{{ asset('storage/' . $categories[$loop->index + 1]->image) }}"
                                alt="{{ $categories[$loop->index + 1]->name }}"
                            >
                        </div>

                    @endif

                @endif
            @endforeach
        </div>
    </section>

    {{-- JS --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('#menu-tabs .nav-link');
                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        tabs.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        const target = this.dataset.target;
                        if (target === 'top') {
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                            return;
                        }
                        const el = document.getElementById(target);
                        if (el) {
                            el.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
            });
        </script>
    @endpush

</x-front-layout>
