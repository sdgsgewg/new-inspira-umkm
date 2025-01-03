@foreach ($checkoutItems as $sellerId => $sellerGroup)
    <div class="seller-section">
        @foreach ($sellerGroup['items'] as $design)
            @foreach ($design->product->options as $option)
                <div class="mb-2">
                    <label for="option_value{{ $option->id }}" class="form-label">
                        @php
                            $productName = Lang::has('designs.products.' . $design->product->name)
                                ? __('designs.products.' . $design->product->name)
                                : $design->product->name;

                            $optionName = Lang::has('options.options.' . $option->name)
                                ? __('options.options.' . $option->name)
                                : $option->name;
                        @endphp

                        @if (app()->getLocale() === 'en')
                            {{ $productName . ' ' . $optionName . ' (' . $design->title . ') :' }}
                        @else
                            {{ $optionName . ' ' . $productName . ' (' . $design->title . ') :' }}
                        @endif
                    </label>

                    <select
                        class="form-select @error('option_value_id.' . $design->id . '.' . $option->id) is-invalid @enderror"
                        name="option_value_id[{{ $design->id }}][{{ $option->id }}]"
                        id="option_value{{ $option->id }}" required>
                        <option value="">@lang('checkout.select_option_value')</option>
                        @foreach ($design->product->name === 'Packaging' ? $option->values : $design->category->optionValues as $value)
                            <option value="{{ $value->id }}"
                                {{ old('option_value_id.' . $design->id . '.' . $option->id) == $value->id ? 'selected' : '' }}>
                                @php
                                    $valueName = Lang::has('options.values.' . $value->value)
                                        ? __('options.values.' . $value->value)
                                        : $value->value;
                                @endphp
                                {{ $valueName }}
                            </option>
                        @endforeach
                    </select>
                    @error('option_value_id.' . $design->id . '.' . $option->id)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
        @endforeach
    </div>
@endforeach
