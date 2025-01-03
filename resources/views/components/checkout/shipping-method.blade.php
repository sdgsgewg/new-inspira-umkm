<div class="d-flex flex-column">
    <label for="shippingMethod" class="form-label">@lang('checkout.shipping_method')</label>

    <select class="form-select" name="shipping_method_id" id="shippingMethod" required>
        <option value="">@lang('checkout.select_shipping_method')</option>
        @foreach ($shippingMethods as $sm)
            <option value="{{ $sm->id }}" data-shipping-fee="{{ $sm->shipping_fee }}"
                {{ old('shipping_method_id') == $sm->id ? 'selected' : '' }}>
                {{ $sm->name }} (Rp{{ number_format($sm->shipping_fee, 2, ',', '.') }}) - {{ $sm->description }}
            </option>
        @endforeach
    </select>

    @error('shipping_method_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
