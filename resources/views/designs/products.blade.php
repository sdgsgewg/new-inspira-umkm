@extends('layouts.main')

@section('container')
    <h1 class="mb-5">{{ $title }}</h1>

    <div class="container">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 mb-3 d-flex align-items-stretch">
                    <a href="{{ route('designs.index', ['product' => $product->slug]) }}" class="w-100">

                        <div class="card text-bg-dark h-100" style="width: 100%; height: 300px;">

                            <?php
                            $url = '../../img/';
                            ?>
                            @if ($product->image)
                                <img src="{{ secure_asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ $url . $product->name . '.jpg' }}"
                                    alt="{{ $product->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @endif

                            <div class="card-img-overlay d-flex align-items-center p-0">
                                <h5 class="card-title text-center flex-fill p-4 fs-3"
                                    style="background-color: rgba(0,0,0,0.7)">{{ $product->name }}</h5>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
