@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/designs/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    {{-- Display Product Big Image --}}
    <div class="row justify-content-center my-5">
        <div class="col-11">
            <div class="img-wrapper rounded-4 overflow-hidden" style="width: auto; height:450px;">
                @if ($product->image)
                    <img src="{{ secure_asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ secure_asset('img/' . $product->name . '.jpg') }}" alt="{{ $product->name }}">
                @endif
            </div>
        </div>
    </div>

    {{-- Display Product Name --}}
    <div class="row justify-content-center">
        <div class="col-11 content-header">
            @php
                $productName = Lang::has('designs.products.' . $product->name)
                    ? __('designs.products.' . $product->name)
                    : $product->name;
            @endphp

            <h2 class="fw-bold">{{ $productName }}</h2>
        </div>
    </div>

    @if ($product->designs->count() > 0)
        @php
            $numCtg = $categories->count();
        @endphp

        <div class="row justify-content-center">
            <div class="col-11">
                @foreach ($categories->take(2) as $category)
                    @include('components.designs.category-designs')
                @endforeach
            </div>
        </div>

        {{-- Another Category --}}
        <div class="row justify-content-center">
            <div class="col-11 moreContent" style="display: none;">
                @foreach ($categories->skip(2) as $category)
                    @include('components.designs.category-designs')
                @endforeach
            </div>
        </div>

        @if ($numCtg > 2)
            @include('components.designs.view-more-less')
        @endif
    @else
        <div class="row justify-content-center">
            <div class="col-11">
                @include('components.designs.noDesign')
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @include('components.designs.design-script')
@endsection
