@extends('layouts.main')

@section('container')
    <div class="row justify-content-center mt-5">
        <div class="col-11 col-md-8 col-lg-6">
            <div class="card p-4 h-100">
                <h4 class="text-center mb-4">@lang('subscriptions.subscription_details')</h4>
                <div class="d-flex flex-column mb-3">
                    {{-- Plan Name --}}
                    <div class="d-flex flex-row justify-content-between">
                        <p>
                            <strong>
                                @lang('subscriptions.name')
                            </strong>
                        </p>
                        <p>
                            {{ $plan->name }}
                        </p>
                    </div>
                    {{-- Plan Price --}}
                    <div class="d-flex flex-row justify-content-between">
                        <p>
                            <strong>
                                @lang('subscriptions.price')
                            </strong>
                        </p>
                        <p>
                            Rp{{ number_format($plan->price, 2, ',', '.') }}
                        </p>
                    </div>
                </div>

                <hr class="mt-0 mb-4">

                {{-- Payment Decision --}}
                <div class="d-flex flex-row align-items-center justify-content-center gap-3">
                    {{-- Cancel --}}
                    <a href="{{ route('subscriptions.cancel', $subscription) }}" class="btn btn-danger">
                        @lang('subscriptions.button.cancel')
                    </a>

                    {{-- Pay Now --}}
                    <button type="submit" class="btn btn-success text-transform-uppercase" id="pay-button">
                        {{ __('subscriptions.button.pay_now') }}
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
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // Show loading spinner
            document.getElementById('payment-loading').classList.remove('d-none');

            snap.pay('{{ $subsPayment->snap_token }}', {
                onSuccess: function(result) {
                    window.location.href =
                        '{{ route('subscriptions.success', ['subscription' => $subscription->id]) }}';
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
