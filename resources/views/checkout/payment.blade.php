@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/cart/style.css') }}?v={{ time() }}">
@endsection

@section('container')

    <div class="row justify-content-center mt-5">
        <div class="col-11 d-flex flex-column">
            <div class="d-flex flex-row align-items-center">
                <h1>{{ $title }}</h1>
            </div>
            <hr class="mb-4">
        </div>

        <form method="POST"
            action="{{ route('transactions.store-transaction', ['transaction' => $transaction->order_number]) }}"
            id="payment-form">
            @csrf

            <div class="row d-flex flex-wrap justify-content-center">
                @if (count($designs) > 0)
                    <div class="col-11">
                        <div class="row d-flex flex-wrap justify-content-center">
                            <div class="col-12 col-lg-6">
                                {{-- Seller --}}
                                <div class="sellerBox d-flex flex-row">
                                    <a href="{{ route('designs.seller', ['seller' => $seller->username]) }}"
                                        class="text-decoration-none fs-3">
                                        {{ $seller->name }} &rsaquo;</a>
                                </div>

                                {{-- Design Item --}}
                                @foreach ($designs as $design)
                                    @include('components.checkout.checkoutItem', [
                                        'quantity' => $design['pivot']['quantity'],
                                    ])
                                @endforeach

                                <div class="d-flex flex-row justify-content-between mt-2">
                                    {{-- Product Amount --}}
                                    <h6>@lang('checkout.ordered_amount') ({{ $productAmount }}
                                        {{ $productAmount > 1 ? __('checkout.products') : __('checkout.product') }})
                                    </h6>

                                    {{-- Subtotal Price --}}
                                    <h6 class="text-info fw-bold">
                                        {{ 'Rp' . number_format($subTotalPrice, 0, ',', '.') }}
                                    </h6>
                                </div>

                            </div>

                            {{-- Order Detail --}}
                            <div class="col-12 col-lg-6 d-flex flex-column ps-lg-5 mt-4 mt-lg-0 gap-3">
                                <h2 class="mb-1 mb-lg-3">@lang('checkout.order_detail')</h2>

                                {{-- Option dari setiap design --}}
                                @foreach ($optionValueResults as $result)
                                    <p class="m-0">
                                        {{ $result->product_name . ' ' . $result->option_name . ' (' . $result->design_title . '): ' . $result->option_value }}
                                    </p>
                                @endforeach

                                {{-- Notes for seller --}}
                                <p class="m-0">
                                    {{ __('checkout.notes_for_seller') . ' ' . $notes }}
                                </p>

                                {{-- Shipping Method --}}
                                <div>
                                    <p class="m-0">@lang('checkout.shipping_method')</p>
                                    <p class="m-0">
                                        {{ $shippingMethod->name . ' (Rp' . number_format($shippingMethod->shipping_fee, 0, ',', '.') . ')' }}
                                    </p>
                                    <small class="text-muted m-0">{{ $shippingMethod->description }}</small>
                                </div>

                                {{-- Payment Method --}}
                                @include('components.checkout.payment-method')
                            </div>
                        </div>
                    </div>

                    <div class="col-12 my-4">
                        <hr>
                    </div>

                    {{-- Price Summary --}}
                    @include('components.checkout.price-summary', [
                        'col' => 'col-11',
                        'subTotalPrice' => $subTotalPrice,
                        'shippingFee' => $shippingFee,
                        'serviceFee' => $serviceFee,
                        'grandTotalPrice' => $grandTotalPrice,
                    ])

                    @include('components.checkout.checkout-button', ['navigateTo' => 'proceed_to_payment'])
                @endif
            </div>
        </form>
    </div>

@endsection
