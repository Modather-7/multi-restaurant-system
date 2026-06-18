<div class="empty-cart">
    <i class="lni lni-cart"></i>

    <h3>Your Cart is Empty</h3>

    <p>
        Looks like you haven't added any meals yet.
        Browse our menu and find something delicious.
    </p>

    <a href="{{ route('restaurant.menu.index', [$restaurant, $branch]) }}" class="empty-cart-btn">
        Browse Menu
    </a>
</div>
