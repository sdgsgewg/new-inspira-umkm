@extends('layouts.main')

@section('container')
    {{-- Back --}}
    <div class="row justify-content-center mt-4">
        <div class="col-11">
            <a href="{{ auth()->user()->is_admin ? route('transactions.orderRequest') : route('transactions.index') }}"
                class="btn btn-success d-inline-flex mb-3">
                <i class="bi bi-arrow-left me-2"></i> @lang('order.back')
            </a>
        </div>
    </div>

    {{-- Status Transaksi & Informasi User --}}
    <div class="row justify-content-center mt-2">
        <div class="col-11">
            <div class="card d-flex flex-column overflow-hidden">
                @if (in_array($transaction->transaction_status, ['Not Paid', 'Returned', 'Cancelled']))
                    <div class="card-header fw-bold bg-danger">
                        {{ __('order.order') . ' ' . __('order.status.' . $transaction->transaction_status) }}
                    </div>
                @elseif (in_array($transaction->transaction_status, ['Pending', 'Accepted', 'Delivered']))
                    <div class="card-header fw-bold bg-warning text-dark">
                        {{ __('order.order') . ' ' . __('order.status.' . $transaction->transaction_status) }}
                    </div>
                @else
                    <div class="card-header fw-bold bg-success">
                        {{ __('order.order') . ' ' . __('order.status.' . $transaction->transaction_status) }}
                    </div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">@lang('order.delivery_address')</h6>
                    <div class="d-flex">
                        <div>
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="d-flex flex-column ms-3">
                            <div class="d-flex gap-3">
                                <p class="m-0 mb-1">
                                    {{ $transaction->buyer->name }} | <span
                                        class="text-secondary">{{ $transaction->buyer->phoneNumber }}</span>
                                </p>
                            </div>
                            <div>
                                {{ $transaction->buyer->address }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shipping Information --}}
    <div class="row justify-content-center mt-3">
        <div class="col-11">
            <div class="card d-flex flex-column">
                <div class="card-header d-inline-flex">
                    <i class="bi bi-truck me-2"></i>
                    <p class="fw-bold m-0">@lang('order.shipping')</p>
                </div>
                <div class="card-body">
                    {{-- Shipping Method --}}
                    <div class="d-flex justify-content-between mb-3">
                        <p>@lang('order.shipping_method')</p>
                        <div class="d-flex flex-column">
                            <p class="text-end m-0">{{ $transaction->shipping->shippingMethod->name }}</p>
                            <small class="text-muted text-end">
                                {{ $transaction->shipping->shippingMethod->description }}
                            </small>

                        </div>
                    </div>
                    {{-- Shipping Status --}}
                    <div class="d-flex justify-content-between">
                        <p class="m-0">@lang('order.shipping_status')</p>
                        <p class="m-0">{{ __('order.shipping_statuses.' . $transaction->shipping->shipping_status) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Item Transaksi --}}
    <div class="row justify-content-center mt-3">
        <div class="col-11">
            @include('components.transaction.orderDetailCard')
        </div>
    </div>

    {{-- Payment Information --}}
    @if ($transaction->payment)
        <div class="row justify-content-center mt-3">
            <div class="col-11">
                <div class="card d-flex flex-column">
                    <div class="card-header d-inline-flex">
                        <i class="bi bi-wallet me-2"></i>
                        <p class="fw-bold m-0">@lang('order.payment')</p>
                    </div>
                    <div class="card-body">
                        {{-- Payment Method --}}
                        <div class="d-flex justify-content-between">
                            <p>@lang('order.payment_method')</p>
                            <p>{{ $transaction->payment->paymentMethod->name }}</p>
                        </div>
                        {{-- Payment Status --}}
                        <div class="d-flex justify-content-between">
                            <p class="m-0">@lang('order.payment_status')</p>
                            <p class="m-0">{{ __('order.payment_statuses.' . $transaction->payment->payment_status) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Infomasi Detail Transaksi --}}
    <div class="row justify-content-center mt-3">
        <div class="col-11">
            <div class="card d-flex flex-column">
                {{-- Order Number --}}
                <div class="card-header d-flex justify-content-between">
                    <p class="fw-bold m-0">@lang('order.order_number')</p>
                    <p class="m-0">{{ $transaction->order_number }}</p>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        {{-- Waktu Pembuatan Transaksi --}}
                        <div class="d-flex justify-content-between">
                            <p>@lang('order.order_time')</p>
                            <p>
                                {{ \Carbon\Carbon::parse($transaction->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </p>
                        </div>

                        {{-- Payment Time --}}
                        @if ($transaction->payment)
                            <div class="d-flex justify-content-between">
                                <p>@lang('order.payment_time')</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($transaction->payment->payment_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif

                        {{-- Delivery Time --}}
                        @if ($transaction->shipping->shipping_time !== null)
                            <div class="d-flex justify-content-between">
                                <p>@lang('order.shipping_time')</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($transaction->shipping->shipping_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif

                        {{-- Receive Item Time --}}
                        @if ($transaction->shipping->delivery_time !== null)
                            <div class="d-flex justify-content-between">
                                <p>@lang('order.received_time')</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($transaction->shipping->delivery_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif

                        {{-- Completion Time --}}
                        @if ($transaction->completion_time !== null)
                            <div class="d-flex justify-content-between">
                                <p class="m-0">@lang('order.completion_time')</p>
                                <p class="m-0">
                                    {{ \Carbon\Carbon::parse($transaction->completion_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
