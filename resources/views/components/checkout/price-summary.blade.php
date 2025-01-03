<div class="{{ $col }} d-flex flex-column mb-4">
    <div class="d-flex align-items-center gap-3 mb-3">
        <i class="bi bi-journal-text fs-3"></i>
        <h3 class="m-0">@lang('checkout.order_summary')</h3>
    </div>

    {{-- Subtotal for all Products --}}
    <div class="d-flex flex-row justify-content-between">
        <p>@lang('checkout.subtotal')</p>
        <p>
            {{ 'Rp' . number_format($subTotalPrice, 0, ',', '.') }}
        </p>
    </div>

    {{-- Shipping Fee --}}
    <div class="d-flex flex-row justify-content-between">
        <p>@lang('checkout.shipping_fee')</p>
        <p id="shippingFeeDisplay">
            {{ 'Rp' . number_format($shippingFee, 0, ',', '.') }}
        </p>
    </div>

    {{-- Service Fee --}}
    <div class="d-flex flex-row justify-content-between">
        <p>@lang('checkout.service_fee')</p>
        <p>
            {{ 'Rp' . number_format($serviceFee, 0, ',', '.') }}
        </p>
    </div>

    {{-- Total Payment --}}
    <div class="d-flex flex-row justify-content-between">
        <h5 class="fw-bold">@lang('checkout.total_payment')</h5>
        <h5 class="text-success-emphasis fw-bold" id="grandTotalPriceDisplay">
            {{ 'Rp' . number_format($grandTotalPrice, 0, ',', '.') }}
        </h5>
    </div>

    <hr>
</div>
