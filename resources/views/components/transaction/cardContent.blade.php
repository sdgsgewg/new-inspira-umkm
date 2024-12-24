@php
    $products = 0;
@endphp

@foreach ($transaction->designs as $design)
    <div class="col-12 mb-3 d-flex flex-row">
        <div class="img-wrapper col-2 col-lg-2">
            @if ($design->image)
                <img src="{{ secure_asset('storage/' . $design->image) }}" alt="...">
            @else
                <img src="{{ secure_asset('img/' . $design->product->name) . '.jpg' }}" alt="...">
            @endif
        </div>
        <div class="card-info col-10 col-lg-10 ps-4 d-flex flex-column justify-content-between">
            <div>
                <h5>{{ $design->title }}</h5>
                <p class="text-end">x{{ $design->pivot->quantity }}</p>
            </div>
            <div>
                <p class="text-end">Rp{{ number_format($design->price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    @php
        $products += $design->pivot->quantity;
    @endphp
@endforeach

<div class="col-12 d-flex flex-row justify-content-end">
    <h5>
        Total {{ $products }}
        {{ count($transaction->designs) > 1 ? __('order.products') : __('order.product') }}:
        <strong>Rp{{ number_format($transaction->grand_total_price, 0, ',', '.') }}</strong>
    </h5>
</div>
