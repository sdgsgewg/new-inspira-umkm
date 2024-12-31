@extends('dashboard.layouts.main')

@section('container')
    <div class="row my-3">
        <div class="col-12 col-sm-11 col-lg-10">
            <h1 class="mb-3">{{ $design['title'] }}</h1>

            <a href="{{ route('admin.designs.index') }}" class="btn btn-success d-inline-flex"><i
                    class="bi bi-arrow-left me-2"></i>@lang('dashboard.back')</a>

            <a href="{{ route('admin.designs.edit', ['design' => $design->slug]) }}" class="btn btn-warning d-inline-flex"><i
                    class="bi bi-pencil-square me-2"></i>
                @lang('dashboard.edit')</a>

            <button type="button" class="btn btn-danger d-inline-flex" data-bs-toggle="modal"
                data-bs-target="#deleteModal-{{ $design->id }}">
                <i class="bi bi-x-circle icon me-2"></i>@lang('dashboard.delete')
            </button>

            @include('components.modals.dashboard.delete-modal', [
                'item' => $design,
                'resourceType' => 'design',
                'resourceUrl' => 'designs',
            ])

            <div class="d-flex flex-row mt-4" style="max-height: 350px;">
                <div class="col-4 overflow-hidden" style="height: 100%;">
                    @if ($design->image)
                        <img src="{{ $design->image }}" alt="{{ $design->category->name }}"
                            class="img-fluid">
                    @else
                        <img src="{{ secure_asset('img/' . $design->product->name . '.jpg') }}"
                            alt="{{ $design->category->name }}" style="width: 100%; height: 100%; object-fit:cover;">
                    @endif
                </div>
                <div class="col-7 d-flex flex-column ms-5">
                    {{-- Design Product --}}
                    <p>
                        @lang('designs.product')
                        @php
                            $productName = Lang::has('designs.products.' . $design->product->name)
                                ? __('designs.products.' . $design->product->name)
                                : $design->product->name;
                        @endphp
                        {{ $productName }}
                    </p>

                    {{-- Design Category --}}
                    <p>
                        @lang('designs.category')
                        @php
                            $categoryName = Lang::has('designs.categories.' . $design->category->name)
                                ? __('designs.categories.' . $design->category->name)
                                : $design->category->name;
                        @endphp
                        {{ $categoryName }}
                    </p>

                    {{-- Design Rating --}}
                    @if ($avgDesignRating > 0.0)
                        <p>
                            @lang('designs.rating') <span class="badge bg-warning text-dark shadow-sm"
                                style="font-size: 0.9rem; font-weight: bold;">
                                {{ number_format($avgDesignRating, 2) }}
                            </span>
                        </p>
                    @endif
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
                <hr>
            </article>

        </div>
    </div>
@endsection
