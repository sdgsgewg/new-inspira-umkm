@extends('layouts.main')

@section('container')
    {{-- Advertisements --}}
    @include('components.home.advertisements')

    {{-- Product List --}}
    @include('components.home.product-list')

    {{-- Special Offers --}}
    @include('components.home.promotions')

    {{-- <script src="{{ secure_asset('js/ads-slider.js') }}"></script> --}}
@endsection
