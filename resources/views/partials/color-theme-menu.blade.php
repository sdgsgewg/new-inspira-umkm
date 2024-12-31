<ul class="dropdown-menu color-theme-menu {{ auth()->check() ? 'custom-dropdown-position' : 'custom-dropdown-position-guest' }}"
    aria-labelledby="bd-theme-text">
    {{-- Back to Main Menu --}}
    <li>
        <a class="dropdown-item d-inline-flex align-items-center back-to-main-menu" href="javascript:void(0)">
            <i class="bi bi-chevron-left fs-6 me-2"></i>@lang('navbar.theme')
        </a>
    </li>
    <li>
        <hr class="dropdown-divider">
    </li>
    {{-- Light Mode --}}
    <li>
        <button type="button" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3" data-bs-theme-value="light"
            aria-pressed="false">
            <i class="bi bi-sun-fill"></i>@lang('navbar.light')
            <i class="bi ms-auto d-none text-muted bi-check2"></i>
        </button>
    </li>
    {{-- Dark Mode --}}
    <li>
        <button type="button" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3"
            data-bs-theme-value="dark" aria-pressed="false">
            <i class="bi bi-moon-stars-fill"></i>@lang('navbar.dark')
            <i class="bi ms-auto d-none text-muted bi-check2"></i>
        </button>
    </li>
    {{-- Auto --}}
    <li>
        <button type="button" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3"
            data-bs-theme-value="auto" aria-pressed="true">
            <i class="bi bi-circle-half"></i>@lang('navbar.auto')
            <i class="bi ms-auto d-none text-muted bi-check2"></i>
        </button>
    </li>
</ul>
