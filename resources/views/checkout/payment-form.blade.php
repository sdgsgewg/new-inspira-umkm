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

        <form method="POST" action="{{ route('transactions.store') }}" id="payment-form">
            @csrf

            <div class="row d-flex flex-wrap justify-content-center">
                @if (count($checkoutItems) > 0)
                    <div class="col-11">
                        <div class="row d-flex flex-wrap justify-content-center">
                            {{-- Checkout Items --}}
                            <div class="col-11 col-lg-6">
                                @include('components.checkout.checkout-items')
                            </div>

                            {{-- Order Detail --}}
                            <div class="col-11 col-lg-6 d-flex flex-column ps-lg-5 gap-3">
                                <h2 class="mb-3">Order Detail</h2>

                                {{-- Option dari setiap design --}}
                                @foreach ($optionValueOutputs as $output)
                                    <p class="m-0">{{ $output }}</p>
                                @endforeach

                                {{-- Notes for seller --}}
                                <p class="m-0">Notes for Seller: {{ $notes }}</p>

                                {{-- Payment Method --}}
                                <p class="m-0">Payment Method: {{ $paymentMethod->name }}</p>

                                {{-- Shipping Method --}}
                                <div>
                                    <p class="m-0">Shipping Method:</p>
                                    <p class="m-0">
                                        {{ $shippingMethod->name . ' (Rp' . number_format($shippingMethod->shipping_fee, 0, ',', '.') . ')' }}
                                    </p>
                                    <small class="m-0">{{ $shippingMethod->description }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 my-4">
                        <hr>
                    </div>

                    <div class="col-11 d-flex flex-column mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-journal-text fs-3"></i>
                            <h3 class="m-0">Order Summary</h3>
                        </div>
                        @php
                            $sub_total_price = $subTotalPrice;
                            $shipping_fee = $shippingMethod->shipping_fee;
                            $service_fee = 1000;
                            $total_price = $sub_total_price + $shipping_fee + $service_fee;
                        @endphp
                        <div class="d-flex flex-row justify-content-between">
                            <p>Subtotal for Product</p>
                            <p>
                                Rp{{ number_format($sub_total_price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <p>Shipping Fee</p>
                            <p>
                                Rp{{ number_format($shipping_fee, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <p>Service Fee</p>
                            <p>
                                Rp{{ number_format($service_fee, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <h5 class="fw-bold">Total Payment</h5>
                            <h5 class="text-info fw-bold">
                                Rp{{ number_format($total_price, 0, ',', '.') }}
                            </h5>
                        </div>
                        <hr>
                    </div>

                    {{-- Option Values --}}
                    <input type="hidden" name="optionValues" value="{{ json_encode($optionValues) }}">

                    {{-- Notes --}}
                    <input type="hidden" name="notes" value="{{ $notes }}">

                    {{-- Payment Method --}}
                    <input type="hidden" name="payment_method_id" value="{{ $paymentMethod->id }}">

                    {{-- Shipping Method --}}
                    <input type="hidden" name="shipping_method_id" value="{{ $shippingMethod->id }}">

                    {{-- Price --}}
                    <input type="hidden" name="subTotalPrice" value="{{ $sub_total_price }}">
                    <input type="hidden" name="shippingFee" value="{{ $shipping_fee }}">
                    <input type="hidden" name="serviceFee" value="{{ $service_fee }}">
                    <input type="hidden" name="totalPrice" value="{{ $total_price }}">

                    {{-- Design Items --}}
                    <input type="hidden" name="checkoutItems" value="{{ json_encode($checkoutItems) }}">

                    {{-- Source Page --}}
                    <input type="hidden" name="source" value={{ $source }}>
                    <input type="hidden" name="quantity" value="{{ $quantity }}">

                    @include('components.checkout.checkout-button', ['navigateTo' => 'Pay Now'])
                @endif
            </div>
        </form>
    </div>


@endsection

@section('scripts')
    {{-- <script src="{{ secure_asset('js/transaction/checkout.js') }}?v={{ time() }}"></script> --}}

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay({{ $transaction->snap_token }}, {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endsection
