<style>
    .fs-lg-3 {
        font-size: 1.75rem;
    }

    .fs-lg-5 {
        font-size: 1.25rem;
    }

    /* Extra Large Screens (>= 1200px) */
    @media screen and (min-width: 1200px) {
        .promo-card {
            height: 280px;
        }
    }

    /* Large Screens (992px - 1199px) */
    @media screen and (min-width: 992px) and (max-width: 1199px) {
        .promo-card {
            height: 250px;
        }
    }

    /* Medium Screens (768px - 991px) */
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .promo-card {
            height: 250px;
        }
    }

    /* Small Screens (< 768px) */
    @media screen and (min-width: 576px) and (max-width: 767px) {
        .promo-card {
            height: 250px;
        }
    }

    @media screen and (max-width: 575px) {
        .promo-card {
            height: 200px;
        }
    }
</style>

<div class="row justify-content-center mb-5">
    <div class="col-12 position-relative mt-5">
        <div class="promo position-absolute"
            style="top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1; background-color: white; padding: 10px; border-radius: 15px;">
            <p class="fs-5 fw-bold m-1" style="color: #28a745;">@lang('home.special_offers')</p>
        </div>
        <hr>
    </div>
</div>

<div class="row justify-content-center mb-5">
    <div class="col-11">
        @if ($promotions->count())
            @foreach ($promotions as $promo)
                @include('components.home.promotion-card')
            @endforeach
            <div class="d-flex align-items-center justify-content-center mt-5">
                {{ $promotions->links() }}
            </div>
        @else
            <div>
                No promotion yet.
            </div>
        @endif
    </div>
</div>
