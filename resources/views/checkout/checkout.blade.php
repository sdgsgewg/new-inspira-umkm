@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/cart/style.css') }}?v={{ time() }}">
@endsection

@section('container')

    <div class="row justify-content-center mt-5">
        <div class="col-11 d-flex flex-column">
            <div class="d-flex flex-row align-items-center">
                <a href="{{ route('carts.index') }}" class="btn btn-success me-3"><i class="bi bi-arrow-left"></i></a>
                <h1>@lang('checkout.title.Checkout')</h1>
            </div>
            <hr class="mb-4">

            <form method="POST" action="{{ route('transactions.store') }}" id="checkout-form">
                @csrf

                @if (count($checkoutItems) > 0)
                    {{-- Delivery Address --}}
                    <div class="d-flex flex-column">
                        <h6 class="fw-bold">@lang('checkout.delivery_address')</h6>
                        <div class="d-flex">
                            <div>
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="d-flex flex-column ms-3">
                                <div class="d-flex gap-3">
                                    <p class="m-0 mb-1">
                                        {{ $buyer->name }} | <span class="text-secondary">{{ $buyer->phoneNumber }}</span>
                                    </p>
                                </div>
                                <div>
                                    {{ $buyer->address }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">

                    <div class="row d-flex flex-wrap justify-content-between">
                        {{-- Checkout Items --}}
                        <div class="col-12 col-lg-6">
                            @include('components.checkout.checkout-items')
                        </div>

                        {{-- Checkout Confirmation --}}
                        <div class="col-12 col-lg-6 d-flex flex-column ps-lg-5 gap-3 mt-4 mt-lg-0">
                            <h3>@lang('checkout.order_confirmation')</h3>

                            {{-- Option dari setiap design --}}
                            @include('components.checkout.design-option')

                            {{-- Notes for seller --}}
                            <div class="col-12 d-flex flex-column">
                                <label for="notes" class="form-label mb-0">@lang('checkout.notes_for_seller')</label>
                                <small class="fst-italic  text-secondary my-1">@lang('checkout.optional')</small>
                                <textarea class="w-100" name="notes" id="notes" rows="3" placeholder="@lang('checkout.input_notes')"></textarea>
                            </div>

                            {{-- Shipping Method --}}
                            @include('components.checkout.shipping-method')
                        </div>
                    </div>

                    <div class="col-12 mt-5 mb-4">
                        <hr>
                    </div>

                    {{-- Price Summary --}}
                    @include('components.checkout.price-summary', [
                        'col' => 'col-12',
                        'subTotalPrice' => $subTotalPrice,
                        'shippingFee' => 0,
                        'serviceFee' => $serviceFee,
                        'grandTotalPrice' => $subTotalPrice + 0 + $serviceFee,
                    ])

                    {{-- HIDDEN INPUT --}}
                    {{-- Design Items --}}
                    <input type="hidden" name="checkoutItems" value="{{ json_encode($checkoutItems) }}">

                    {{-- Price --}}
                    <input type="hidden" name="subTotalPrice" value="{{ $subTotalPrice }}">
                    <input type="hidden" name="shippingFee" value="{{ 0 }}">
                    <input type="hidden" name="serviceFee" value="{{ $serviceFee }}">
                    <input type="hidden" name="grandTotalPrice" value="{{ 0 }}">

                    {{-- Source Page --}}
                    <input type="hidden" name="source" value="{{ session('fromPage') }}">

                    @if (session('fromPage') !== 'Cart')
                        <input type="hidden" name="quantity" value="{{ $quantity }}">
                    @endif

                    @include('components.checkout.checkout-button', ['navigateTo' => 'checkout'])
                @endif
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const subtotal = {{ $subTotalPrice }};
        const serviceFee = {{ $serviceFee }};
    </script>
    <script src="{{ secure_asset('js/checkout/price.js') }}"></script>
@endsection
