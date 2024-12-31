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

    /* Ads Big Image */
    .ads-big-image {
        width: auto;
        height: 350px;
    }

    /* Extra Large Screens (>= 1200px) - Display 4 cards */
    @media screen and (min-width: 1200px) {
        .ads-big-image {
            height: 350px;
        }
    }

    /* Large Screens (992px - 1199px) - Display 3 cards */
    @media screen and (min-width: 992px) and (max-width: 1199px) {
        .ads-big-image {
            height: 350px;
        }
    }

    /* Medium Screens (768px - 991px) - Display 2 cards */
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .ads-big-image {
            height: 350px;
        }
    }

    /* Small Screens (< 768px) - Display 1 card */
    @media screen and (min-width: 576px) and (max-width: 767px) {
        .ads-big-image {
            height: 300px;
        }
    }

    @media screen and (max-width: 575px) {
        .ads-big-image {
            height: 250px;
        }
    }
</style>

<div class="row justify-content-center my-5">
    <div class="col-11 position-relative">
        @php
            $advertisements = 3;
        @endphp
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"
            data-ads-amount="{{ $advertisements }}">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                @for ($i = 0; $i < $advertisements; $i++)
                    <div class="carousel-item @if ($i === 0) active @endif">
                        <div class="ads-big-image img-wrapper rounded-4 overflow-hidden">
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
