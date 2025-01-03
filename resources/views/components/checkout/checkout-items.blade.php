{{-- Checkout Items --}}
@php
    $idx = 0;
@endphp
@foreach ($checkoutItems as $sellerId => $sellerGroup)
    <div class="seller-section">
        <div class="sellerBox d-flex flex-row">
            <a href="{{ route('designs.seller', ['seller' => $sellerGroup['seller_username']]) }}"
                class="text-success-emphasis text-decoration-none color-inherit fs-3">
                {{ $sellerGroup['seller_name'] }} &rsaquo;</a>
        </div>
        @foreach ($sellerGroup['items'] as $design)
            @include('components.checkout.checkoutItem', [
                'quantity' => session('fromPage') === 'Cart' ? $design['pivot']['quantity'] : $quantity,
            ])
        @endforeach
        <div class="d-flex flex-row justify-content-between mt-2">
            <h6>@lang('checkout.ordered_amount') ({{ $productAmount[$idx] }}
                {{ $productAmount[$idx] > 1 ? __('checkout.products') : __('checkout.product') }})</h6>
            <h6 class="text-success-emphasis fw-bold">
                Rp{{ number_format($checkoutItemsPrice[$idx], 0, ',', '.') }}
            </h6>
        </div>
    </div>
    @php
        $idx++;
    @endphp
@endforeach
