<x-front-layout title="Our Fine Menu">

    {{-- HERO + CATEGORIES --}}
    <section class="menu-hero-section">
        <div class="container">
            <div class="menu-hero-content text-center">
                <span class="menu-badge">
                    Premium Food Experience
                </span>
                <h1 class="menu-title">
                    Explore Our Menu
                </h1>
                <p class="menu-subtitle">
                    Fresh ingredients, rich flavors, and dishes crafted with love.
                </p>
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
    <section class="menu-products-section">
        <div class="container">
            {{-- TOP ANCHOR --}}
            <div id="top"></div>
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
                                        <x-product-card :product="$product" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
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
