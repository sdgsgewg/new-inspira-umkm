<ul
    class="dropdown-menu localization-menu {{ auth()->check() ? 'custom-dropdown-position' : 'custom-dropdown-position-guest' }}">
    <li>
        <a class="dropdown-item d-inline-flex align-items-center back-to-main-menu" href="javascript:void(0)">
            <i class="bi bi-chevron-left fs-6 me-2"></i></i>@lang('navbar.language')
        </a>
    </li>
    <li>
        <hr class="dropdown-divider">
    </li>
    <li>
        <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }} py-2"
            href="{{ route('changeLanguage', ['lang' => 'en']) }}">
            @lang('navbar.english')
        </a>
    </li>
    <li>
        <a class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }} py-2"
            href="{{ route('changeLanguage', ['lang' => 'id']) }}">
            @lang('navbar.bahasa_indonesia')
        </a>
    </li>
</ul>
