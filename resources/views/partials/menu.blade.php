{{-- Logo Inspira UMKM --}}
<li class="nav-item mb-3 mb-lg-0">
    <div class="d-flex align-items-center" style="width: 40px; height: 40px;">
        <a class="nav-link {{ Request::is('/') ? 'active' : '' }} p-0" href="{{ route('home') }}">
            <img src="{{ secure_asset('img/inspira.png') }}" alt=""
                style="width: 100%; height: 100%; object-fit: cover;">
        </a>
    </div>
</li>

{{-- Home --}}
<li class="nav-item">
    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">@lang('navbar.home')</a>
</li>

{{-- Designs --}}
<li class="nav-item">
    <a class="nav-link {{ Request::is('designs*') || Request::is('filtered-designs*') ? 'active' : '' }}"
        href="{{ route('designs.index') }}">@lang('navbar.designs')</a>
</li>

{{-- Search Button --}}
<div class="col-lg-5 my-3 my-lg-0">
    @include('components.search', ['id' => 1])
</div>

{{-- About Us Page --}}
<li class="nav-item">
    <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ route('about') }}">@lang('navbar.about_us')</a>
</li>

{{-- Login --}}
@if (!auth()->check())
    <li class="nav-item">
        <a href="{{ route('login') }}" class="nav-link d-flex {{ Request::is('login') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-right me-2"></i> @lang('navbar.login')
        </a>
    </li>
@endif
