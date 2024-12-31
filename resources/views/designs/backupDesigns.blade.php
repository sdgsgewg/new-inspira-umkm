@extends('layouts.main')

@section('container')
    @include('components.designs.designHeader')

    @php
        $numProduct = $products->count();
    @endphp

    @if ($designsByProduct->count())
        <div class="row justify-content-center">
            <div class="col-11">
                @foreach ($products->take(2) as $product)
                    @include('components.designs.product-designs')
                @endforeach
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-11 moreContent" style="display: none;">
                @foreach ($products->skip(2) as $product)
                    @include('components.designs.product-designs')
                @endforeach
            </div>
        </div>

        @if ($numProduct > 2)
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
