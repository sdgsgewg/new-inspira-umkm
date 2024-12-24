<script>
    const choice = 'design';
</script>
<script src="{{ secure_asset('js/dashboard/script.js') }}?v={{ time() }}"></script>

<script>
    const routeGetCategoriesByProduct = '{{ route('admin.designs.getCategoriesByProduct', ':id') }}';
    const oldProductId = "{{ old('product_id', $design->product_id ?? '') }}";
    const oldCategoryId = "{{ old('category_id', $design->category_id ?? '') }}";
</script>
<script src="{{ secure_asset('js/designs/loadCategory.js') }}?v={{ time() }}"></script>
