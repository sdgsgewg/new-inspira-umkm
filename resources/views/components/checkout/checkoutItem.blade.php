<div class="card my-3 d-flex flex-row">

    <div class="col-4">
        <div class="img-wrapper col-md-4">
            @if ($design['image'])
                <img src="{{ secure_asset('storage/' . $design['image']) }}" class="rounded-start" alt="...">
            @else
                <img src="{{ secure_asset('img/' . $design['product']['name']) . '.jpg' }}" class="rounded-start" alt="...">
            @endif
        </div>
    </div>

    <div class="col-8">
        <div class="card-body d-flex flex-row justify-content-between h-100">
            <div class="d-flex flex-column justify-content-between">
                <div class="design-title">
                    <h5>{{ $design['title'] }}</h5>
                </div>
                <div class="design-price">
                    <p class="mb-0">Rp{{ number_format($design['price'], 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-end">
                <p class="qty d-flex flex-column justify-content-center m-0" data-design-id="{{ $design['id'] }}"
                    data-qty="{{ $quantity }}">
                    x{{ $quantity }}
                </p>
            </div>
        </div>
    </div>

</div>
