@extends('layouts.main')

@section('css')
    <style>
        .tick {
            top: 0%;
            left: 50%;
            width: 140px;
            height: 140px;
            transform: translate(-50%, -50%);
        }
    </style>
@endsection

@section('container')
    <div class="row justify-content-center mt-5">
        <div class="col-11 col-sm-8 col-lg-6 col-xl-5 mt-5">
            <div class="card position-relative col-12">
                {{-- Icon Centang --}}
                <div class="tick position-absolute rounded-circle overflow-hidden">
                    <img src="{{ secure_asset('img/tick-2.png') }}" alt="">
                </div>
                <div class="card-body d-flex flex-column">
                    {{-- Informasi penting transaksi --}}
                    <div class="d-flex flex-column justify-content-center align-items-center pt-3 mt-5">
                        <h1>
                            Rp{{ number_format($plan->price, '0', '', '.') }}
                        </h1>
                        <p class="text-success fs-4 mt-2 mb-0">@lang('subscriptions.payment_success')</p>
                        <p class="text-secondary mt-1">@lang('subscriptions.thanks_msg')</p>
                    </div>

                    {{-- Ringkasan Transaksi --}}
                    <div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">@lang('subscriptions.name')</p>
                            <p class="fw-bold m-0">{{ $plan->name }}</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">@lang('subscriptions.payment_method')</p>
                            <p class="fw-bold m-0">{{ $subs_payment->paymentMethod->name }}</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">@lang('subscriptions.total_payment')</p>
                            <p class="fw-bold m-0">Rp{{ number_format($plan->price, 0, '', '.') }}</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">@lang('subscriptions.payment_time')</p>
                            <p class="fw-bold m-0">
                                {{ \Carbon\Carbon::parse($subs_payment->payment_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">@lang('subscriptions.start_date')</p>
                            <p class="fw-bold m-0">
                                {{ \Carbon\Carbon::parse($subs->start_date)->timezone('Asia/Jakarta')->format('d-m-Y') }}
                            </p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">@lang('subscriptions.end_date')</p>
                            <p class="fw-bold m-0">
                                {{ \Carbon\Carbon::parse($subs->end_date)->timezone('Asia/Jakarta')->format('d-m-Y') }}
                            </p>
                        </div>
                        <hr>
                    </div>

                    {{-- Navigation Button --}}
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        {{-- Back to Home Page --}}
                        <a href="{{ route('home') }}" class="btn btn-primary">@lang('subscriptions.to_home_page')</a>

                        {{-- View My Subscriptions --}}

                        @php
                            session()->flash('success', __('subscriptions.subs_created'));
                        @endphp

                        <a href="{{ route('subscriptions.index') }}" class="btn btn-success">@lang('subscriptions.to_my_subs')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
