<script>
    const qtyURL = "{{ route('carts.updateQuantity') }}";
    const checkURL = "{{ route('carts.updateIsChecked') }}";
</script>

<script src="{{ asset('js/cart/quantity.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/cart/isChecked.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/cart/checkoutButton.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/cleanModalBackdrop.js') }}?v={{ time() }}"></script>
