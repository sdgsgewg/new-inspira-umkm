<div class="payment d-flex flex-column">
    <label for="paymentMethod" class="form-label">@lang('checkout.payment_method')</label>

    <select class="form-select" @error('payment_method_id') is-invalid @enderror" name="payment_method_id"
        id="paymentMethod" required>
        <option value="">@lang('checkout.select_payment_method')</option>
        @foreach ($paymentMethods as $pm)
            <option value="{{ $pm->id }} {{ old('payment_method_id' == $pm->id) ? 'selected' : '' }}">
                {{ $pm->name }}</option>
        @endforeach
    </select>
    @error('payment_method_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
