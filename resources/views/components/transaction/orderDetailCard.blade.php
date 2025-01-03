<div class="card col-12 rounded p-3 d-flex flex-column">
    @include('components.modals.sendFeedbackStatusModal')

    <div class="col-12 mb-2">
        <a href="{{ route('designs.seller', ['seller' => $seller->username]) }}"
            class="text-decoration-none color-inherit fw-bold fs-6">
            {{ $seller->name }}</a>
    </div>

    {{-- Designs List --}}
    @foreach ($designs as $design)
        <div class="col-12 mb-3 d-flex flex-column">
            <div class="d-flex flex-row">
                {{-- Image --}}
                <div class="img-wrapper col-3 col-lg-2">
                    @if ($design->image)
                        <img src="{{ $design->image }}" alt="...">
                    @else
                        <img src="{{ secure_asset('img/' . $design->product_name . '.jpg') }}" alt="...">
                    @endif
                </div>
                <div class="card-info col-9 col-lg-10 ps-4 d-flex flex-column justify-content-between">
                    <div>
                        {{-- Title --}}
                        <h5>{{ $design->title }}</h5>

                        {{-- Design Option Value --}}
                        @php
                            // Product Name
                            $productName = Lang::has('designs.products.' . $design->product_name)
                                ? __('designs.products.' . $design->product_name)
                                : $design->product_name;

                            // Option Name
                            $optionName = Lang::has('options.options.' . $design->option_name)
                                ? __('options.options.' . $design->option_name)
                                : $design->option_name;

                            // Option Value Name
                            $valueName = Lang::has('options.values.' . $design->option_value)
                                ? __('options.values.' . $design->option_value)
                                : $design->option_value;
                        @endphp

                        @if (app()->getLocale() === 'en')
                            <small class="m-0">
                                {{ $productName . ' ' . $optionName . ': ' . $valueName }}
                            </small>
                        @else
                            <small class="m-0">
                                {{ $optionName . ' ' . $productName . ': ' . $valueName }}
                            </small>
                        @endif

                        {{-- Quantity --}}
                        <p class="mt-2">{{ 'x' . $design->quantity }}</p>
                    </div>
                    {{-- Price --}}
                    <div class="mt-auto">
                        <p class="m-0">{{ 'Rp' . number_format($design->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Send Feedback Button --}}
            @if (!$isSeller && (!$design->user_rating || !$design->user_rating))
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
                {{ 'Rp' . number_format($transaction->total_price, 0, ',', '.') }}
            </p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <p>@lang('order.shipping_fee')</p>
            <p>
                {{ 'Rp' . number_format($transaction->shipping->shippingMethod->shipping_fee, 0, ',', '.') }}
            </p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <p class="m-0">@lang('order.service_fee')</p>
            <p class="m-0">
                {{ 'Rp' . number_format($transaction->service_fee, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <hr>

    <div class="col-12 d-flex flex-row justify-content-end">
        <h5 class="m-0 py-1">@lang('order.total_order')
            <strong>{{ 'Rp' . number_format($transaction->grand_total_price, 0, ',', '.') }}</strong>
        </h5>
    </div>

</div>
