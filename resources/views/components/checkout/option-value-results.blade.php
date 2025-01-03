@foreach ($optionValueResults as $result)
    @php
        // Product Name
        $productName = Lang::has('designs.products.' . $result->product_name)
            ? __('designs.products.' . $result->product_name)
            : $result->product_name;

        // Option Name
        $optionName = Lang::has('options.options.' . $result->option_name)
            ? __('options.options.' . $result->option_name)
            : $result->option_name;

        // Option Value Name
        $valueName = Lang::has('options.values.' . $result->option_value)
            ? __('options.values.' . $result->option_value)
            : $result->option_value;
    @endphp

    @if (app()->getLocale() === 'en')
        <p class="m-0">
            {{ $productName . ' ' . $optionName . ' (' . $result->design_title . '): ' . $valueName }}
        </p>
    @else
        <p class="m-0">
            {{ $optionName . ' ' . $productName . ' (' . $result->design_title . '): ' . $valueName }}
        </p>
    @endif
@endforeach
