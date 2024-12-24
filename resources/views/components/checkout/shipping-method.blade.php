<div class="d-flex flex-column">
    <label for="shippingMethod" class="form-label">@lang('checkout.shipping_method')</label>

    <select class="form-select" @error('shipping_method_id') is-invalid @enderror" name="shipping_method_id"
        id="shippingMethod" required>
        <option value="">@lang('checkout.select_shipping_method')</option>
        @foreach ($shippingMethods as $sm)
            <option value="{{ $sm->id }} {{ old('shipping_method_id' == $sm->id) ? 'selected' : '' }}">
                <p>{{ $sm->name }}</p>
                <small>{{ ' (Rp' . number_format($sm->shipping_fee, 2, ',', '.') . ')' }}</small>
                <small>{{ ' (' . $sm->description . ')' }}</small>
            </option>
        @endforeach
    </select>
    @error('shipping_method_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
