@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/cart/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    <div class="row justify-content-center mt-5">
        <div class="col-11 col-md-8 col-lg-6">
            <div class="card p-4 h-100">
                <h4 class="text-center mb-4">@lang('checkout.checkout_details')</h4>
                <div class="d-flex flex-column mb-3">
                    @foreach ($transaction_designs as $index => $td)
                        @php
                            $index++;
                        @endphp
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex flex-column">
                                <p>
                                    <strong>@lang('checkout.subtotal') #{{ $index }}</strong>
                                </p>
                                <p>
                                    {{ '(' . $td->design->title . ')' }}
                                </p>
                            </div>
                            <p>
                                Rp{{ number_format($td->sub_total_price, 2, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                    <div class="d-flex flex-row justify-content-between">
                        <p class="text-start"><strong>@lang('checkout.shipping_fee')</strong></p>
                        <p class="text-end">
                            Rp{{ number_format($transaction->shipping->shippingMethod->shipping_fee, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <p class="text-start"><strong>@lang('checkout.service_fee')</strong></p>
                        <p class="text-end">
                            Rp{{ number_format($transaction->service_fee, 2, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <hr>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <p class="text-start">
                            <strong>@lang('checkout.total_payment')</strong>
                        </p>
                        <p class="text-end">
                            Rp{{ number_format($transaction->grand_total_price, 2, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Payment Decision --}}
                <div class="d-flex flex-row align-items-center justify-content-center gap-3">
                    {{-- Cancel --}}
                    <a href="{{ route('transactions.cancel', $transaction) }}" class="btn btn-danger">
                        @lang('checkout.button.cancel')
                    </a>

                    {{-- Pay Now --}}
                    <button type="submit" class="btn btn-success text-transform-uppercase" id="pay-button">
                        {{ __('checkout.button.pay_now') }}
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div id="payment-loading" class="d-none text-center mt-4">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p>Processing your payment...</p>
    </div>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // Show loading spinner
            document.getElementById('payment-loading').classList.remove('d-none');

            snap.pay('{{ $transaction->snap_token }}', {
                onSuccess: function(result) {
                    window.location.href =
                        '{{ route('payments.payment-success', ['transaction' => $transaction->order_number]) }}';
                },
                onPending: function(result) {
                    document.getElementById('payment-loading').classList.add('d-none');
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onError: function(result) {
                    document.getElementById('payment-loading').classList.add('d-none');
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endsection
