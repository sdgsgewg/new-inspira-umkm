<footer class="bg-dark text-light">
    <div class="container py-4 pt-20">
        <div class="row justify-content-between">
            <div class="col-md-4 mb-4">
                <a href="{{ route('home') }}" class="d-flex align-items-center mb-3">
                    <img src="{{ asset('img/inspira.png') }}" class="me-3 w-25 h-auto" alt="Inspira Logo">
                </a>
                <div class="text-muted">
                    <p class="mt-4">@lang('footer.contact')</p>
                    <div class="mt-3">
                        <p class="text-light mb-1">Email:</p>
                        <p>inspiraumkm@gmail.com</p>
                    </div>
                    <div>
                        <p class="text-light mb-1">@lang('footer.time')</p>
                        <p>08:00 - 21:00, @lang('footer.days')</p>
                    </div>
                </div>
            </div>
            <div class="col-md-7 row">
                <div class="col-sm-4 mb-4">
                    <h2 class="h6 text-uppercase text-light text-decoration-underline mb-3">@lang('footer.menu')</h2>
                    <ul class="list-unstyled text-muted">
                        <li><a href="{{ route('home') }}" class="text-decoration-none text-light">@lang('footer.home')</a></li>
                        <li><a href="{{ route('designs.index') }}" class="text-decoration-none text-light">@lang('footer.design')</a></li>
                        <li><a href="{{ route('about') }}" class="text-decoration-none text-light">@lang('footer.aboutus')</a></li>
                        <li><a href="{{ route('register') }}" class="text-decoration-none text-light">@lang('footer.join')</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 mb-4">
                    <h2 class="h6 text-uppercase text-light text-decoration-underline mb-3">@lang('footer.product')</h2>
                    <ul class="list-unstyled text-muted">
                        <li><a href="{{ route('designs.product', ['product' => 'packaging']) }}" class="text-decoration-none text-light">@lang('footer.packaging')</a></li>
                        <li><a href="{{ route('designs.product', ['product' => 'banners']) }}" class="text-decoration-none text-light">@lang('footer.banner')</a></li>
                        <li><a href="{{ route('designs.product', ['product' => 'stickers']) }}" class="text-decoration-none text-light">@lang('footer.sticker')</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h2 class="h6 text-uppercase text-light text-decoration-underline mb-3">@lang('footer.medsos')</h2>
                    <div class="d-flex gap-2">
                        <a href="#" class="d-flex align-items-center">
                            <img src="{{ asset('img/Facebook.png') }}" class="h-8" alt="Facebook">
                        </a>
                        <a href="#" class="d-flex align-items-center">
                            <img src="{{ asset('img/Twitter Circled.png') }}" class="h-8" alt="Twitter">
                        </a>
                        <a href="#" class="d-flex align-items-center">
                            <img src="{{ asset('img/Instagram Circle.png') }}" class="h-8" alt="Instagram">
                        </a>
                        <a href="#" class="d-flex align-items-center">
                            <img src="{{ asset('img/LinkedIn.png') }}" class="h-8" alt="LinkedIn">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <span class="text-muted">© 2024
                <a href="{{ route('home') }}" class="text-decoration-none text-light">Inspira UMKM</a>. All Rights Reserved.
            </span>
        </div>
    </div>
</footer>