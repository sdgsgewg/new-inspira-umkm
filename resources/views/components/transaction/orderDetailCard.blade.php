<div class="card col-12 rounded p-3 d-flex flex-column">
    @include('components.modals.sendFeedbackStatusModal')

    <div class="col-12 mb-2">
        <a href="{{ route('designs.seller', ['seller' => $transaction->seller->username]) }}"
            class="text-decoration-none color-inherit fw-bold fs-6">
            {{ $transaction->seller->name }}</a>
    </div>

    @php
        $products = 0;
    @endphp

    {{-- Designs List --}}
    @foreach ($transaction->designs as $design)
        <div class="col-12 mb-3 d-flex flex-column">
            <div class="d-flex flex-row">
                <div class="img-wrapper col-3 col-lg-2">
                    @if ($design->image)
                        <img src="{{ $design->image }}" alt="...">
                    @else
                        <img src="{{ secure_asset('img/' . $design->product->name) . '.jpg' }}" alt="...">
                    @endif
                </div>
                <div class="card-info col-9 col-lg-10 ps-4 d-flex flex-column justify-content-between">
                    <div>
                        <h5>{{ $design->title }}</h5>
                        <p>x{{ $design->pivot->quantity }}</p>
                    </div>
                    <div>
                        <p>Rp{{ number_format($design->price, 0, ',', '.') }}</p>
                    </div>

                    @php
                        $userRating = $design->reviewByUser(Auth::id());
                        $isSeller = Auth::id() === $transaction->seller->id; // Check if the current user is the seller
                    @endphp
                </div>
            </div>
            @if (!$isSeller && (!$userRating || !$userRating->isRated))
                <div class="col-12 d-flex flex-row-reverse mt-2">
                    @if ($transaction->transaction_status === 'Completed')
                        <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#sendFeedbackModal-{{ $design->id }}">
                            @lang('order.send_feedback')
                        </button>
                        @include('components.modals.sendFeedbackModal', ['design' => $design])
                    @endif
                </div>
            @endif
        </div>
    @endforeach

    {{-- Promotion --}}
    @if ($transaction->promotions->count())
        <hr class="mt-1 mb-4">
        @foreach ($transaction->promotions as $promo)
            <div class="col-12 mb-3 d-flex flex-column">
                <div class="d-flex flex-row">
                    <div class="img-wrapper col-3 col-lg-2">
                        @if ($promo->image)
                            <img src="{{ secure_asset('storage/' . $promo->image) }}" alt="...">
                        @else
                            <img src="{{ secure_asset('img/Drink.jpg') }}" alt="...">
                        @endif
                    </div>
                    <div class="card-info col-9 col-lg-10 ps-4 d-flex flex-column justify-content-between">
                        <div>
                            <h5>{{ $promo->title }}</h5>
                            <p>x{{ $promo->pivot->quantity }}</p>
                        </div>
                        <div>
                            <p>Rp{{ number_format($promo->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <hr>

    {{-- Notes --}}
    <div class="col-12">
        <p class="fw-bold">@lang('order.notes'):</p>
        <p class="m-0">{{ $transaction->notes }}</p>
    </div>

    <hr>

    {{-- Transaction Fee --}}
    <div class="col-12 d-flex flex-column text-secondary">
        <div class="d-flex flex-row justify-content-between">
            <p>@lang('order.subtotal_for_product')</p>
            <p>
                Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
            </p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <p>@lang('order.shipping_fee')</p>
            <p>
                Rp{{ number_format($transaction->shipping->shippingMethod->shipping_fee, 0, ',', '.') }}
            </p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <p class="m-0">@lang('order.service_fee')</p>
            <p class="m-0">
                Rp{{ number_format($transaction->service_fee, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <hr>

    <div class="col-12 d-flex flex-row justify-content-end">
        <h5 class="m-0 py-1">@lang('order.total_order')
            <strong>Rp{{ number_format($transaction->grand_total_price, 0, ',', '.') }}</strong>
        </h5>
    </div>

</div>
