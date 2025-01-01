<ul
    class="dropdown-menu subscriptions-menu {{ auth()->check() ? 'custom-dropdown-position' : 'custom-dropdown-position-guest' }}">
    <li>
        <a class="dropdown-item d-inline-flex align-items-center back-to-main-menu" href="javascript:void(0)">
            <i class="bi bi-chevron-left fs-6 me-2"></i></i>@lang('navbar.subscriptions')
        </a>
    </li>
    <li>
        <hr class="dropdown-divider">
    </li>
    <li>
        <a class="dropdown-item d-inline-flex {{ Request::is('subscriptions/pricing') ? 'active' : '' }} py-2"
            href="{{ route('subscriptions.pricing') }}">
            <i class="bi bi-gem me-2"></i>@lang('navbar.subscribe')
        </a>
    </li>
    <li>
        <a class="dropdown-item d-inline-flex {{ Request::is('subscriptions') ? 'active' : '' }} py-2"
            href="{{ route('subscriptions.index') }}">
            <i class="bi bi-folder me-2"></i>@lang('navbar.my_subs')
        </a>
    </li>
</ul>
