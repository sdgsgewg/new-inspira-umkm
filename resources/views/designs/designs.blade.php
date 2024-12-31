@extends('layouts.main')

@section('container')
    @include('components.designs.designHeader')

    <div class="row justify-content-center mt-5">
        <div class="col-11">
            @if ($designs->count())
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

@section('scripts')
    @include('components.designs.design-script')
@endsection
