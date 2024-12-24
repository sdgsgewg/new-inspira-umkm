@extends('layouts.main')

@section('container')
    {{-- Back --}}
    <div class="row justify-content-center mt-4">
        <div class="col-11">
            <a href="{{ auth()->user()->is_admin ? route('transactions.orderRequest') : route('transactions.index') }}"
                class="btn btn-success d-inline-flex mb-3">
                <i class="bi bi-arrow-left me-2"></i> @lang('order.Back')
            </a>
        </div>
    </div>

    {{-- Status Transaksi & Informasi User --}}
    <div class="row justify-content-center mt-2">
        <div class="col-11">
            <div class="card d-flex flex-column overflow-hidden">
                @if (in_array($transaction->transaction_status, ['Not Paid', 'Returned', 'Cancelled']))
                    <div class="card-header fw-bold bg-danger">
                        {{ __('order.Order') . ' ' . __('order.status.' . $transaction->transaction_status) }}
                    </div>
                @elseif (in_array($transaction->transaction_status, ['Pending', 'Accepted', 'Delivered']))
                    <div class="card-header fw-bold bg-warning text-dark">
                        {{ __('order.Order') . ' ' . __('order.status.' . $transaction->transaction_status) }}
                    </div>
                @else
                    <div class="card-header fw-bold bg-success">
                        {{ __('order.Order') . ' ' . __('order.status.' . $transaction->transaction_status) }}
                    </div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">@lang('order.Delivery Address')</h6>
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

    {{-- Item Transaksi --}}
    <div class="row justify-content-center mt-3">
        <div class="col-11">
            @include('components.transaction.orderDetailCard')
        </div>
    </div>

    {{-- Infomasi Detail Transaksi --}}
    <div class="row justify-content-center mt-3">
        <div class="col-11">
            <div class="card d-flex flex-column">
                <div class="card-header d-flex justify-content-between">
                    <p class="fw-bold m-0">@lang('order.Order Number')</p>
                    <p class="m-0">{{ $transaction->order_number }}</p>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="m-0">@lang('order.Payment Method')</p>
                        <p class="m-0">{{ $transaction->payment->paymentMethod->name }}</p>
                    </div>
                    <hr>
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <p>@lang('order.Order Time')</p>
                            <p>
                                {{ \Carbon\Carbon::parse($transaction->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </p>
                        </div>
                        @if ($transaction->payment->payment_time !== null)
                            <div class="d-flex justify-content-between">
                                <p>@lang('order.Payment Time')</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($transaction->payment->payment_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif
                        @if ($transaction->shipping->shipping_time !== null)
                            <div class="d-flex justify-content-between">
                                <p>@lang('order.Shipping Time')</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($transaction->shipping->shipping_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif
                        @if ($transaction->shipping->delivery_time !== null)
                            <div class="d-flex justify-content-between">
                                <p>@lang('order.Received Time')</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($transaction->shipping->delivery_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif
                        @if ($transaction->completion_time !== null)
                            <div class="d-flex justify-content-between">
                                <p class="m-0">@lang('order.Completion Time')</p>
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
