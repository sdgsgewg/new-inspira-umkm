@extends('layouts.main')

@section('container')
    <link rel="stylesheet" href="{{ asset('css/designs/style.css') }}?v={{ time() }}">

    {{-- Display Product Big Image --}}
    <div class="row justify-content-center my-5">
        <div class="col-11">
            <div class="img-wrapper rounded-4 overflow-hidden" style="width: auto; height:450px;">
                <img src="{{ asset('img/' . $category->product->name . '.jpg') }}" alt="">
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
