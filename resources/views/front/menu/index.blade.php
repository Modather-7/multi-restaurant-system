<x-front-layout title="Our Fine Menu">

    {{-- Hero / Categories --}}
    <section class="menu-hero-section">
        <div class="container">
            <div class="menu-hero-content text-center">
                <span class="menu-badge">
                    Premium Food Experience
                </span>
                <h1 class="menu-title">
                    Explore Our Delicious Menu
                </h1>
                <p class="menu-subtitle">
                    Fresh ingredients, rich flavors, and dishes crafted with love.
                </p>
            </div>
            {{-- Categories --}}
            <div class="menu-categories-wrapper">
                <ul class="nav justify-content-center gap-2 flex-wrap" id="menu-tabs">
                    <li class="nav-item">
                        <button class="nav-link active" data-filter="all">
                            All Items
                        </button>
                    </li>
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <button class="nav-link" data-filter="cat-{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Products --}}
    <section class="menu-products-section">
        <div class="container">
            <div class="row" id="filterable-products">

                @forelse($products as $product)
                    <div class="col-xl-4 col-md-6 col-12 mb-4 product-item cat-{{ $product->category_id }}">
                        <div class="product-card-animation">
                            <x-product-card :product="$product" />
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-products-box text-center">
                            <i class="lni lni-empty-file"></i>
                            <h4>
                                No items found
                            </h4>
                            <p>
                                There are currently no products available.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('#menu-tabs .nav-link');
                const items = document.querySelectorAll('.product-item');
                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        tabs.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        const filterValue = this.getAttribute('data-filter');
                        items.forEach(item => {
                            if (
                                filterValue === 'all' ||
                                item.classList.contains(filterValue)
                            ) {
                                item.style.display = 'block';
                                item.style.animation =
                                    'fadeProduct .35s ease';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                });
            });
        </script>
    @endpush

</x-front-layout>
