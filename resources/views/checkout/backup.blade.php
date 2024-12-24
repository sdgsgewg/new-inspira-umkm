@extends('layouts.main')

@section('container')

    <link rel="stylesheet" href="{{ asset('css/cart/style.css') }}?v={{ time() }}">

    <div class="row justify-content-center mt-5">
        <div class="col-11 col-md-10 col-lg-8 d-flex flex-column">
            <div class="d-flex flex-row align-items-center">
                <a href="{{ route('carts.index') }}" class="btn btn-success me-3"><i class="bi bi-arrow-left"></i></a>
                <h1>{{ $title }}</h1>
            </div>
            <hr class="mb-4">

            @if (count($checkoutItems) > 0)
                <div class="d-flex flex-column">
                    <h6 class="fw-bold">Delivery Address</h6>
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
                <hr>

                @php
                    $idx = 0;
                @endphp
                @foreach ($checkoutItems as $sellerId => $sellerGroup)
                    <div class="seller-section">
                        <div class="sellerBox d-flex flex-row">
                            <div class="div">
                                <a href="{{ route('designs.seller', ['seller' => $sellerGroup['seller_username']]) }}"
                                    class="text-decoration-none fs-3">
                                    {{ $sellerGroup['seller_name'] }} &rsaquo;</a>
                            </div>
                        </div>
                        @foreach ($sellerGroup['items'] as $design)
                            @include('components.checkout.checkoutItem', [
                                'quantity' =>
                                    session('fromPage') === 'Cart' ? $design->pivot->quantity : $quantity,
                            ])
                        @endforeach
                        <div class="d-flex flex-row justify-content-between mt-2">
                            <h6>Ordered Amount ({{ $productAmount[$idx] }}
                                {{ $productAmount[$idx] > 1 ? 'products' : 'product' }})</h6>
                            <h6 class="text-info fw-bold">
                                Rp{{ number_format($checkoutItemsPrice[$idx], 0, ',', '.') }}
                            </h6>
                        </div>
                    </div>
                    @php
                        $idx++;
                    @endphp
                    <hr>
                @endforeach

                <form method="POST" action="{{ route('transactions.store') }}" id="checkout-form">
                    @csrf
                    <div class="payment d-flex flex-column">
                        <div>
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select id="paymentMethod" class="form-select" @error('paymentMethod') is-invalid @enderror"
                                name="paymentMethod" required>
                                <option value="">Select a payment method</option>
                                <option value="GoPay">GoPay</option>
                                <option value="OVO">OVO</option>
                                <option value="ShopeePay">ShopeePay</option>
                            </select>
                            @error('paymentMethod')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr>

                    <div class="d-flex flex-column mb-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-journal-text fs-3"></i>
                            <h3 class="m-0">Order Summary</h3>
                        </div>
                        @php
                            $sub_total_price = $totalPrice;
                            $shipping_fee = 10000;
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

                    <input type="hidden" name="subTotalPrice" value="{{ $sub_total_price }}">
                    <input type="hidden" name="shippingFee" value="{{ $shipping_fee }}">
                    <input type="hidden" name="serviceFee" value="{{ $service_fee }}">
                    <input type="hidden" name="totalPrice" value="{{ $total_price }}">
                    <input type="hidden" name="checkoutItems" value="{{ json_encode($checkoutItems) }}">
                    <input type="hidden" name="source" value="cart">

                    <button type="submit"
                        class="btn btn-primary rounded-pill py-2 mt-2 text-decoration-none text-light w-100">
                        Create Order
                    </button>

                </form>
            @endif
        </div>
    </div>
@endsection
