@php
    $designAmount = 0;
@endphp
@if ($product->designs->count())
    <div class="d-flex justify-content-between align-items-center content-header mb-3">
        <h2 class="fw-bold">
            @php
                $productName = Lang::has('designs.products.' . $product->name)
                    ? __('designs.products.' . $product->name)
                    : $product->name;
            @endphp
            {{ $productName }}
        </h2>
        <a href="{{ route('designs.product', ['product' => $product->slug]) }}"
            class="d-flex align-items-center view-all-link btn btn-primary">
            @lang('designs.view_all') <i class="bi bi-arrow-right-circle ms-2"></i>
        </a>
    </div>

    @php
        $designAmount += $product->designs->count();
    @endphp

    <div id="carouselExample{{ $product->id }}" class="carousel mb-5" data-design-amount="{{ $designAmount }}">

        <div class="carousel-inner">
            @foreach ($product->designs->take(6) as $index => $design)
                <div class="carousel-item @if ($index === 0) active @endif">
                    @include('components.designs.card', ['design' => $design])
                </div>
            @endforeach
        </div>

        @include('components.designs.carousel-control')

    </div>
@endif
