<style>
    .carousel-control-prev,
    .carousel-control-next {
        background-color: #28a745;
        border: none;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background-color: #218838;
    }

    .carousel-control-prev:focus,
    .carousel-control-next:focus {
        outline: none;
    }
</style>

<div class="row justify-content-center my-5">
    <div class="col-11 position-relative">
        @php
        $advertisements = 3;
        @endphp
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-ads-amount="{{ $advertisements }}">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                @for ($i = 0; $i < $advertisements; $i++)
                    <div class="carousel-item @if ($i === 0) active @endif">
                    <div class="img-wrapper rounded-4 overflow-hidden" style="width: auto; height:350px;">
                        <img src="{{ secure_asset('img/Accessories.jpg') }}" class="d-block w-100 rounded-4"
                            alt="">
                    </div>
            </div>
            @endfor
        </div>

        @if ($advertisements > 1)
        <button class="carousel-control-prev btn btn-success" type="button"
            data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next btn btn-success" type="button"
            data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif

    </div>
</div>
</div>