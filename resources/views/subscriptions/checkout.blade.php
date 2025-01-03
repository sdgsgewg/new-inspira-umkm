@extends('layouts.main')

@section('container')
    <div class="row justify-content-center mt-5">
        <div class="col-11 d-flex flex-column">
            <h1>{{ $title }}</h1>
            <hr class="mb-4">

            <form method="POST" action="{{ route('subscriptions.store') }}" id="checkout-form">
                @csrf

                <div class="row d-flex flex-wrap justify-content-between">
                    {{-- Subscription Plan --}}
                    <div class="col-12 col-lg-6">
                        <h5>{{ $plan->name }}</h5>
                        <h5>Rp{{ number_format($plan->price, 2, ',', '.') }}</h5>
                    </div>
                    {{-- Subscription Confirmation --}}
                    <div class="col-12 col-lg-6 d-flex flex-column ps-lg-5 gap-3 mt-4 mt-lg-0">
                        <h3>@lang('subscriptions.subs_confirmation')</h3>

                        {{-- Payment Method --}}
                        @include('components.checkout.payment-method')
                    </div>
                </div>
                <hr class="my-4">

                <div class="d-flex flex-row align-items-center justify-content-center gap-3">
                    {{-- Cancel --}}
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-primary text-decoration-none">
                        @lang('subscriptions.button.cancel')
                    </a>

                    {{-- Proceed to Payment --}}
                    <button type="submit" class="btn btn-success text-transform-uppercase">
                        {{ __('subscriptions.button.subscribe') }}
                    </button>
                </div>

                {{-- Plan --}}
                <input type="hidden" name="plan" value="{{ $plan }}">

            </form>
        </div>
    </div>
@endsection
