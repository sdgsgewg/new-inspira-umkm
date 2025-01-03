@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/designs/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    @include('components.modals.addToCartModal')

    <div class="row justify-content-center mt-4 mb-5">
        <div class="col-11 col-lg-10 col-xl-8">
            <h1 class="mt-2 mb-3">{{ $design['title'] }}</h1>
            <div class="mb-3">
                <p>
                    @lang('designs.by')
                    <a href="{{ route('designs.seller', ['seller' => $design->seller->username]) }}"
                        class="text-decoration-none">
                        {{ $design->seller->name }}
                    </a>
                </p>
            </div>

            <div class="d-flex flex-row" style="max-height: 350px;">
                <div class="col-5 col-md-4 overflow-hidden">
                    @if ($design->image)
                        <div style="max-height: 350px; overflow:hidden">
                            <img src="{{ $design->image }}" alt="{{ $design->name }}" class="img-fluid">
                        </div>
                    @else
                        <img src="{{ secure_asset('img/' . $design->product->name . '.jpg') }}" alt="{{ $design->name }}"
                            width="1200" height="400" class="img-fluid">
                    @endif
                </div>
                <div class="col-6 col-md-7 d-flex flex-column ms-5">
                    <p>@lang('designs.product')
                        <a href="{{ route('designs.product', ['product' => $design->product->slug]) }}"
                            class="text-decoration-none">
                            @php
                                $productName = Lang::has('designs.products.' . $design->product->name)
                                    ? __('designs.products.' . $design->product->name)
                                    : $design->product->name;
                            @endphp

                            {{ $productName }}
                        </a>
                    </p>
                    <p>@lang('designs.category')
                        <a href="{{ route('designs.category', ['category' => $design->category->slug]) }}"
                            class="text-decoration-none">
                            @php
                                $categoryName = Lang::has('designs.categories.' . $design->category->name)
                                    ? __('designs.categories.' . $design->category->name)
                                    : $design->category->name;
                            @endphp

                            {{ $categoryName }}
                        </a>
                    </p>

                    @if ($avgDesignRating > 0.0)
                        <p>@lang('designs.rating') <span class="badge bg-warning text-dark shadow-sm"
                                style="font-size: 0.9rem; font-weight: bold;">
                                {{ number_format($avgDesignRating, 2) }}
                            </span></p>
                    @endif

                    <div class="col-6 col-md-12 d-flex flex-column flex-md-row gap-3 mt-auto">
                        @if (auth()->check() && auth()->user()->id !== $design->seller->id)
                            {{-- Add to Cart --}}
                            <button class="btn {{ $design->stock > 0 ? 'btn-primary' : 'btn-secondary' }} d-inline-flex justify-content-center align-items-center"
                                data-bs-toggle="modal" data-bs-target="#quantityModal" data-action="add-to-cart"
                                data-route="{{ route('carts.store') }}" data-submit="{{ __('quantity.add_to_cart') }}"
                                {{ $design->stock == 0 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus me-2"></i>@lang('designs.add_to_cart')
                            </button>

                            {{-- Checkout --}}
                            <button class="btn {{ $design->stock > 0 ? 'btn-success' : 'btn-secondary' }} d-inline-flex justify-content-center align-items-center"
                                data-bs-toggle="modal" data-bs-target="#quantityModal" data-action="checkout"
                                data-route="{{ route('checkouts.checkoutFromDesign') }}"
                                data-submit="{{ __('quantity.checkout') }}" {{ $design->stock == 0 ? 'disabled' : '' }}>
                                <i class="bi bi-bag-check me-2"></i>@lang('designs.checkout')
                            </button>

                            {{-- Input Quantity Modal --}}
                            @include('components.modals.input-quantity-modal', [
                                'design' => $design,
                            ])
                        @endif
                    </div>
                </div>
            </div>

            {{-- Design Detailed Information --}}
            <article class="mt-4 fs-6">
                <hr>
                <h2 class="mb-3">@lang('designs.detailed_information')</h2>
                <p>@lang('designs.price') Rp{{ number_format($design->price, 2, ',', '.') }}</p>
                <p>@lang('designs.stock') {{ $design->stock }}</p>
                <p>{{ __('designs.sold') . ': ' . $soldQuantity }}</p>
            </article>

            {{-- Design Description --}}
            <article class="mt-3 fs-6">
                <hr>
                <h2>@lang('designs.description')</h2>
                {!! $design->description !!}
            </article>

            {{-- Review Section --}}
            @include('components.designs.design-review-section')

            {{-- Discussion Section --}}
            @include('components.designs.comments.design-comment-section')
        </div>
    </div>
@endsection

@section('scripts')
    @include('components.designs.design-script')
@endsection
