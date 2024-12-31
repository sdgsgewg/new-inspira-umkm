<style>
    .product-card {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .image-container {
        height: 200px;
        /* Fixed height for the image container */
        background-color: rgb(25, 135, 84);
    }

    .product-name {
        display: flex;
        justify-content: center;
        align-items: start;
        flex-grow: 1;
        text-align: center;
        font-weight: bold;
    }

    .title {
        font-size: xx-large;
        font-weight: bold;
    }
</style>

<div class="row justify-content-center mb-5">
    <div class="col-11">

        <div class="flex flex-col justify-center items-center mb-3">
            <h2 class="title mb-4">INSPIRA UMKM • @lang('home.title')</h2>
            <h3 class="text-center my-5">@lang('home.headline')</h2>
        </div>

        <div class="row d-flex flex-wrap justify-content-evenly gap-3">
            @foreach ($products as $p)
                <div class="product-card col-5 col-sm-4 col-md-3 col-xl-2 d-flex flex-column rounded-4 p-0"
                    style="background-color:#777777"
                    onclick="{{ "window.location.href='" . route('designs.product', ['product' => $p->slug]) . "'" }}">

                    <!-- Image Container -->
                    <div class="image-container d-flex align-items-center justify-content-center rounded-4 p-3 w-100">
                        <div class="overflow-hidden w-100 h-100">
                            @if ($p->image)
                                <img src="{{ $p->image }}" alt="{{ $p->name }}"
                                    class="w-100 h-100 object-fit-cover">
                            @else
                                <img src="{{ secure_asset('img/product/' . $p->slug . '.png') }}"
                                    alt="{{ $p->name }}" class="w-100 h-100 object-fit-cover">
                            @endif
                        </div>
                    </div>

                    <!-- Product Name -->
                    <div class="product-name mt-3 mb-3">
                        @php
                            $productName = Lang::has('designs.products.' . $p->name)
                                ? __('designs.products.' . $p->name)
                                : $p->name;
                        @endphp

                        <p class="fs-4 m-0">{{ $productName }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
