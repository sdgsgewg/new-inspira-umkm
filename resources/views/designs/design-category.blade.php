@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/designs/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    {{-- Display Product Big Image --}}
    <div class="row justify-content-center my-5">
        <div class="col-11">
            <div class="product-big-image img-wrapper rounded-4 overflow-hidden">
                @php
                    $product = $category->product;
                @endphp
                @if ($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ secure_asset('img/' . $product->name . '.jpg') }}" alt="{{ $product->name }}">
                @endif
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-11">
            <div class="content-header mb-4">
                <h2 class="fw-bold">
                    @if ($category->product->name === 'Packaging')
                        {{ $category->name . ' Packaging' }}
                    @elseif ($category->product->name === 'Stickers')
                        {{ 'Kertas Sticker ' . $category->name }}
                    @else
                        {{ $category->name }}
                    @endif
                </h2>
            </div>
            <div class="row d-flex flex-wrap">
                @foreach ($designs as $design)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                        @include('components.designs.card', ['design' => $design])
                    </div>
                @endforeach
            </div>
            <div class="d-flex align-items-center justify-content-center mt-5">
                {{ $designs->links() }}
            </div>
        </div>
    </div>
@endsection
