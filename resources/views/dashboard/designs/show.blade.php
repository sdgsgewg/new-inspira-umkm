@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-12 col-lg-10">
                <h1 class="mb-3">{{ $design['title'] }}</h1>

                <a href="{{ route('admin.designs.index') }}" class="btn btn-success d-inline-flex"><i
                        class="bi bi-arrow-left me-2"></i> Back</a>

                <a href="{{ route('admin.designs.edit', ['design' => $design->slug]) }}"
                    class="btn btn-warning d-inline-flex"><i class="bi bi-pencil-square me-2"></i>
                    Edit</a>

                <form action="{{ route('admin.designs.destroy', ['design' => $design->slug]) }}" method="POST"
                    class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger d-inline-flex" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-x-circle icon me-2"></i> Delete
                    </button>
                </form>

                <div class="d-flex flex-row mt-4" style="max-height: 350px;">
                    <div class="col-4 overflow-hidden" style="height: 100%;">
                        @if ($design->image)
                            <img src="{{ secure_asset('storage/' . $design->image) }}" alt="{{ $design->category->name }}"
                                class="img-fluid">
                        @else
                            <img src="{{ secure_asset('img/' . $design->product->name . '.jpg') }}"
                                alt="{{ $design->category->name }}" style="width: 100%; height: 100%; object-fit:cover;">
                        @endif
                    </div>
                    <div class="col-7 d-flex flex-column ms-5">
                        <p>Product: {{ $design->product->name }}</p>
                        <p>Category: {{ $design->category->name }}
                        </p>
                        @php
                            $averageRating = number_format($design->reviews()->avg('rating'), 2);
                        @endphp
                        @if ($averageRating != 0.0)
                            <p>Rating: <span class="text-warning">{{ $averageRating }}</span></p>
                        @endif
                    </div>
                </div>

                <article class="mt-4 fs-6">
                    <hr>
                    <h2 class="mb-3">Detail Information</h2>
                    <p>Stock: {{ $design->stock }}</p>
                    <p>Price: Rp{{ number_format($design->price, 2, ',', '.') }}</p>
                </article>

                <article class="mt-3 fs-6">
                    <hr>
                    <h2>Description</h2>
                    <p>{!! $design->description !!}</p>
                    <hr>
                </article>

            </div>
        </div>
    </div>
@endsection
