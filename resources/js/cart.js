(function ($) {

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'EGP'
    });

    function currency(amount) {
        return formatter.format(amount || 0);
    }

    function recalculateCart() {
        let subtotal = 0;

        $('.cart-item').each(function () {

            const price = parseFloat($(this).attr('data-price')) || 0;
            const qty = parseInt($(this).find('.item-quantity').val()) || 0;

            const total = price * qty;

            $(this).find('.cart-total').text(currency(total));

            subtotal += total;
        });

        $('.summary-row').eq(0).find('span:last').text(currency(subtotal));
        $('.summary-row.total').find('span:last').text(currency(subtotal));
    }

    // UPDATE QTY (backend sync)
    $('.item-quantity').on('change', function () {

        $.ajax({
            url: `/${locale}/${restaurant_slug}/${branch_slug}/cart/${$(this).data('id')}`,
            method: 'PUT',
            data: {
                quantity: $(this).val(),
                _token: csrf_token
            },
            success: function () {
                recalculateCart();
            }
        });
    });

    // REMOVE ITEM
    $(document).on('click', '.remove-item', function (e) {
        e.preventDefault();

        const id = $(this).data('id');

        $.ajax({
            url: `/${locale}/${restaurant_slug}/${branch_slug}/cart/${$(this).data('id')}`,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: csrf_token
            },
            success: function (res) {

                $(`#${id}`).remove();

                recalculateCart();

                if ($('.cart-item').length === 0) {
                    $('#cart-wrapper').html($('#empty-cart-template').html());
                }
            }
        });
    });

    // PLUS
    $('.qty-plus').on('click', function () {
        let input = $(this).siblings('.item-quantity');
        input.val(parseInt(input.val()) + 1);
        recalculateCart();
        input.trigger('change');
    });

    // MINUS
    $('.qty-minus').on('click', function () {
        let input = $(this).siblings('.item-quantity');
        let qty = parseInt(input.val());

        if (qty > 1) {
            input.val(qty - 1);
            recalculateCart();
            input.trigger('change');
        }
    });


})(jQuery);
