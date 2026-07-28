<div class="empty-cart">
    <i class="lni lni-cart"></i>

    <h3>{{ trans('Your Cart is Empty') }}</h3>

    <p>
        {{ trans("Looks like you haven't added any meals yet.") }}
        {{ trans("Browse our menu and find something delicious.") }}
    </p>

    <a href="{{ route('restaurant.menu.index', [$restaurant, $branch]) }}" class="empty-cart-btn">
        {{ trans('Browse Menu') }}
    </a>
</div>
