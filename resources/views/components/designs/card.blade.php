<style>
    .card-hover {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="card d-flex flex-column h-100 {{ $design->stock > 0 ? 'card-hover' : 'cursor-not-allowed opacity-65' }}"
    onclick="{{ $design->stock > 0 ? "window.location.href='" . route('designs.show', ['design' => $design->slug]) . "'" : '' }}">

    <div class="category position-absolute px-3 py-2 {{ $design->stock > 0 ? 'cursor-pointer' : 'cursor-not-allowed' }}"
        onclick="{{ $design->stock > 0 ? "window.location.href'" . route('designs.category', ['category' => $design->category->slug]) . "'" : '' }}">
        <span class="text-white text-decoration-none">
            @php
                $categoryName = Lang::has('designs.categories.' . $design->category->name)
                    ? __('designs.categories.' . $design->category->name)
                    : $design->category->name;
            @endphp

            {{ $categoryName }}
        </span>
    </div>

    <div class="img-wrapper">
        @if ($design->image)
            <img src="{{ $design->image }}" alt="{{ $design->category->name }}">
        @else
            <img src="{{ secure_asset('img/' . $design->product->name . '.jpg') }}" alt="{{ $design->category->name }}">
        @endif
    </div>

    <div class="card-body d-flex flex-column h-50">
        <div class="mb-3">
            <h5 class="card-title">{{ $design->title }}</h5>

            @if (isset($avgDesignRating[$design->id]) && $avgDesignRating[$design->id] > 0)
                <span class="badge bg-warning text-dark shadow-sm" style="font-size: 0.9rem; font-weight: bold;">
                    {{ $avgDesignRating[$design->id] }}
                </span>
            @endif

        </div>
        <div class="d-flex flex-row align-items-center justify-content-between mt-auto">
            <p class="my-auto">Rp{{ number_format($design->price, 0, ',', '.') }}</p>
            <p class="my-auto">
                {{ isset($soldQuantities[$design->id]) && $soldQuantities[$design->id] > 0 ? $soldQuantities[$design->id] . ' ' . __('designs.sold') : '' }}
            </p>
        </div>
    </div>

    @if ($design->stock == 0)
        <div class="notAvailable d-flex flex-column justify-content-center">
            <p class="text-center fw-bold m-0">@lang('designs.out_of_stock')</p>
        </div>
    @endif
</div>
