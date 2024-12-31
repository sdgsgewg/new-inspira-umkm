<style>
    .nav-link {
        text-transform: uppercase;
    }

    .dropdown-menu {
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .d-none {
        display: none !important;
    }

    @media (max-width: 992px) {
        .offcanvas .col-12 {
            width: 100%;
        }
    }
</style>

<nav class="position-relative navbar navbar-expand-lg bg-dark sticky-top border-bottom" data-bs-theme="dark">
    <div class="col-12 d-flex justify-content-between px-5 py-2">
        {{-- Logo Inspira UMKM --}}
        @include('partials.logo')

        {{-- Dropdown Toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"
            aria-controls="offcanvas" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Offcanvas Menu --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasLabel">InspiraUMKM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body position-relative">
                <ul class="navbar-nav position-relative flex-grow-1 justify-content-between">
                    {{-- Menu --}}
                    @include('partials.menu')
                    {{-- Dropdown Menu --}}
                    @include('partials.dropdown-menu')
                </ul>
            </div>
        </div>
    </div>
</nav>


@if (auth()->check() && !auth()->user()->is_admin)
    <script src="{{ secure_asset('js/navbar/navbar-login.js') }}"></script>
@else
    <script src="{{ secure_asset('js/navbar/navbar.js') }}"></script>
@endif
