<style>
    .fs-lg-3 {
        font-size: 1.75rem;
    }

    .fs-lg-5 {
        font-size: 1.25rem;
    }

    /* Extra Large Screens (>= 1200px) */
    @media screen and (min-width: 1200px) {
        .offer-card {
            height: 280px;
        }
    }

    /* Large Screens (992px - 1199px) */
    @media screen and (min-width: 992px) and (max-width: 1199px) {
        .offer-card {
            height: 250px;
        }
    }

    /* Medium Screens (768px - 991px) */
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .offer-card {
            height: 250px;
        }
    }

    /* Small Screens (< 768px) */
    @media screen and (min-width: 576px) and (max-width: 767px) {
        .offer-card {
            height: 250px;
        }
    }

    @media screen and (max-width: 575px) {
        .offer-card {
            height: 200px;
        }
    }
</style>


<div class="row justify-content-center mb-5">
    <div class="col-12 position-relative mt-5">
        <div class="offer position-absolute"
            style="top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1; background-color: white; padding: 10px; border-radius: 15px;">
            <p class="fs-5 fw-bold m-1" style="color: #28a745;">@lang('home.special_offers')</p>
        </div>
        <hr>
    </div>
</div>

<div class="row justify-content-center mb-5">
    <div class="col-11">
        <div class="card offer-card d-flex flex-row">
            <div class="col-4 col-md-3">
                <img src="{{ asset('img/Drink.jpg') }}" alt="">
            </div>
            <div class="col-8 col-md-9 d-flex flex-column justify-content-evenly align-items-start ps-4 ps-md-5 py-2">
                <p class="fs-4 fs-lg-3 text-uppercase fw-bold m-0">Bundle : Packaging + Stickers</p>
                <p class="fs-6 fs-lg-5 fst-italic fw-light m-0">*Only for VIP Member</p>
                <div class="d-flex flex-row m-0">
                    <p class="fs-6 fs-lg-5">Rp15.000</p>
                    <p class="fs-6 fs-lg-5 text-decoration-line-through ms-4">Rp30.000</p>
                </div>
                <button class="btn btn-success rounded-3 px-3 px-lg-4 py-1 py-lg-2 text-uppercase">
                    Order Now!
                </button>
            </div>
        </div>
    </div>
</div>