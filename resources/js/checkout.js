document.addEventListener('DOMContentLoaded', function () {

    const deliveryBox = document.getElementById('delivery-box');
    const radios = document.querySelectorAll('input[name="order_type"]');
    const deliveryFee = document.getElementById('delivery-fee');

    function handleOrderTypeChange(value) {

        if (value === 'delivery') {
            deliveryBox.classList.remove('d-none');
            deliveryFee.innerText = "Calculated";
        }

        if (value === 'pickup') {
            deliveryBox.classList.add('d-none');
            deliveryFee.innerText = "0 EGP";
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            handleOrderTypeChange(this.value);
        });
    });

    // init state
    const checked = document.querySelector('input[name="order_type"]:checked');
    if (checked) {
        handleOrderTypeChange(checked.value);
    }

});
