<x-front-layout>

<section class="py-5 bg-white border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold text-dark display-5 mb-3">Our Fine Menu</h1>
        <p class="text-muted max-w-600 mx-auto">Explore curated categories built for your selected location. Freshness guaranteed in every selection.</p>
        <div class="d-flex justify-content-center gap-2 mt-4 flex-wrap">
            <ul class="nav nav-pills bg-light p-1 rounded-pill shadow-sm">
                <li class="nav-item">
                    <a href="#" class="nav-link active rounded-pill px-4" data-category="all">All Items</a>
                </li>
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a href="" class="nav-link rounded-pill px-4" data-category="{{ $category->id }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4" id="menu-products-wrapper">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

<script>
    // كود التحكم البصري السريع للانتقال بين الأقسام الممررة ديناميكياً من السيرفر
    document.querySelectorAll('.nav-pills .nav-link').forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.nav-pills .nav-link').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const selectedCategory = tab.getAttribute('data-category');
            document.querySelectorAll('.product-item-card').forEach(card => {
                if (selectedCategory === 'all' || card.getAttribute('data-category') === selectedCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>

</x-front-layout>
