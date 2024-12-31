@include('components.checkout.checkout-promo-item', [
    'quantity' => $quantity,
])
@php
    $idx = 0;
@endphp
@foreach ($checkoutItems as $sellerId => $sellerGroup)
    <div class="seller-section">
        <div class="d-flex flex-row justify-content-between mt-2">
            {{-- Product Amount --}}
            <h6>@lang('checkout.ordered_amount') ({{ $productAmount[$idx] }}
                {{ $productAmount[$idx] > 1 ? __('checkout.products') : __('checkout.product') }})
            </h6>
            {{-- Promotion Price --}}
            <div class="d-flex flex-row m-0">
                {{-- Promo Price --}}
                <h6 class="text-info fw-bold m-0">
                    {{ 'Rp' . number_format($promotion['price'], 0, ',', '.') }}
                </h6>
                {{-- Original Price --}}
                <h6 class="text-decoration-line-through m-0 ms-4">
                    {{ 'Rp' . number_format($promotion['original_price'], 2, ',', '.') }}
                </h6>
            </div>
        </div>
    </div>
    @php
        $idx++;
    @endphp
@endforeach
