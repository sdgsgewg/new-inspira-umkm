<script>
    const qtyURL = "{{ route('carts.updateQuantity') }}";
    const checkURL = "{{ route('carts.updateIsChecked') }}";
</script>

<script src="{{ secure_asset('js/cart/quantity.js') }}?v={{ time() }}"></script>
<script src="{{ secure_asset('js/cart/isChecked.js') }}?v={{ time() }}"></script>
<script src="{{ secure_asset('js/cart/checkoutButton.js') }}?v={{ time() }}"></script>
<script src="{{ secure_asset('js/cleanModalBackdrop.js') }}?v={{ time() }}"></script>
