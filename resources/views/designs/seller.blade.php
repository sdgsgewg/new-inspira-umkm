@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/designs/style.css') }}?v={{ time() }}">

    <style>
        .seller-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    </style>
@endsection

@section('container')
    <div class="row justify-content-center mt-4 mb-5">
        <div class="col-11">
            <div class="d-flex flex-column flex-md-row">
                <div class="col-12 col-md-6 col-lg-5 col-xl-4 d-flex flex-row" style="height: 100%;">
                    {{-- Seller Profile Picture --}}
                    <div class="seller-photo img-thumbnail rounded-circle overflow-hidden"
                        style="width: 100px; height: 100px;">
                        @if ($seller->image)
                            <img src="{{ secure_asset('storage/' . $seller->image) }}" alt="{{ $seller->name }}"
                                class="rounded-circle">
                        @else
                            <img src="{{ secure_asset('img/' . $seller->gender . ' icon.png') }}" alt="{{ $seller->name }}"
                                class="rounded-circle">
                        @endif
                    </div>
                    <div class="d-flex flex-column ms-3">
                        {{-- Seller Name --}}
                        <h4>{{ $seller->name }}</h4>

                        {{-- Chat Button --}}
                        @if ($seller->id !== auth()->user()->id)
                            <a href="{{ route('chats.show', ['chats' => $chat->id]) }}"
                                class="d-inline-flex btn btn-primary px-2 py-1 mt-auto">
                                <i class="bi bi-chat-dots me-2"></i> Chat
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-7 col-xl-8 d-flex flex-column gap-1 ps-lg-2 mt-3 mt-md-0">
                    {{-- Designs Amount --}}
                    <div class="d-inline-flex">
                        <i class="bi bi-palette me-2"></i> Designs: {{ $seller->designs->count() }}
                    </div>

                    {{-- Date Joined --}}
                    <div class="d-inline-flex">
                        <i class="bi bi-calendar me-2"></i> Date Joined: {{ date_format($seller->created_at, 'j F Y') }}
                    </div>

                    {{-- Seller Rating --}}
                    @if ($avgSellerRating > 0.0)
                        <div class="d-inline-flex">
                            <i class="bi bi-star me-2"></i> Rating: <span class="badge bg-warning text-dark shadow-sm ms-2"
                                style="font-size: 0.9rem; font-weight: bold;">
                                {{ $avgSellerRating }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-11">
            @if ($designs->count() > 0)
                <div class="row d-flex flex-wrap align-items-stretch">
                    @foreach ($designs as $design)
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                            @include('components.designs.card')
                        </div>
                    @endforeach
                </div>
                <div class="d-flex align-items-center justify-content-center mt-5">
                    {{ $designs->links() }}
                </div>
            @else
                @include('components.designs.noDesign')
            @endif

        </div>
    </div>
@endsection
