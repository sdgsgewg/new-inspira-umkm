<div class="card promo-card d-flex flex-row">
    {{-- Promo Image --}}
    <div class="col-4 col-md-3">
        @if ($promo->image)
            <img src="{{ secure_asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}">
        @else
            <img src="{{ secure_asset('img/Drink.jpg') }}" alt="{{ $promo->title }}">
        @endif
    </div>
    <div class="col-8 col-md-9 d-flex flex-column justify-content-evenly align-items-start ps-4 ps-md-5 py-2">
        {{-- Title --}}
        <p class="fs-4 fs-lg-3 text-uppercase fw-bold m-0">
            {{ $promo->title }}
        </p>
        {{-- Description --}}
        <p class="fs-6 fs-lg-5 fst-italic fw-light m-0">
            {{ $promo->description }}
        </p>
        {{-- Price --}}
        <div class="d-flex flex-row m-0">
            {{-- Promo Price --}}
            <p class="fs-6 fs-lg-5">
                {{ 'Rp' . number_format($promo->price, '2', ',', '.') }}
            </p>
            {{-- Original Price --}}
            <p class="fs-6 fs-lg-5 text-decoration-line-through ms-4">
                {{ 'Rp' . number_format($promo->original_price, '2', ',', '.') }}
            </p>
        </div>
        {{-- Order Now Button --}}
        <a href="{{ $promo->is_subscribed ? route('promotions.designs', ['promotion' => $promo->slug]) : route('subscriptions.pricing') }}"
            class="btn btn-success rounded-3 px-3 px-lg-4 py-1 py-lg-2 text-uppercase">
            Order Now!
        </a>
    </div>
</div>
