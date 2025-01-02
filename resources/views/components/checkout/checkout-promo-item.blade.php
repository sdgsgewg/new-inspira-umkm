<div class="card my-3 d-flex flex-row">

    <div class="col-4">
        <div class="img-wrapper col-md-4">
            @if ($promotion['image'])
                <img src="{{ $promotion['image'] }}" class="rounded-start" alt="...">
            @else
                <img src="{{ secure_asset('img/Drink.jpg') }}" class="rounded-start" alt="...">
            @endif
        </div>
    </div>

    <div class="col-8">
        <div class="card-body d-flex flex-row justify-content-between h-100">
            <div class="d-flex flex-column justify-content-between">
                {{-- Title --}}
                <div class="promotion-title">
                    <h5>{{ $promotion['title'] }}</h5>
                </div>
                {{-- Price --}}
                <div class="d-flex flex-row m-0">
                    {{-- Promotion Price --}}
                    <p class="m-0">
                        {{ 'Rp' . number_format($promotion->price, 2, ',', '.') }}
                    </p>
                    {{-- Original Price --}}
                    <p class="text-decoration-line-through m-0 ms-4">
                        {{ 'Rp' . number_format($promotion->original_price, 2, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-end">
                <p class="qty d-flex flex-column justify-content-center m-0">
                    x{{ $quantity }}
                </p>
            </div>
        </div>
    </div>

</div>
