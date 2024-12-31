<style>
    /* lg dan ke atas */
    @media screen and (min-width: 992px) {
        .custom-dropdown-position {
            position: absolute !important;
            top: 100 !important;
            left: -100 !important;
            z-index: 100;
        }

        .custom-dropdown-position-guest {
            position: absolute !important;
            top: 100 !important;
            left: -400% !important;
            z-index: 100;
        }
    }

    /* Fallback untuk layar kecil */
    .custom-dropdown-position {
        transform: translateX(0);
    }

    .custom-dropdown-position-guest {
        transform: translateX(0);
    }
</style>

<li class="nav-item dropdown position-relative" data-bs-auto-close="outside">
    {{-- Dropdown Menu Toggle --}}
    <a class="nav-link {{ auth()->check() ? 'dropdown-toggle' : '' }}" href="javascript:void(0)" role="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        @auth
            @lang('navbar.greet'), {{ Str::words(auth()->user()->name, 1, '') }}
        @else
            <i class="bi bi-three-dots"></i>
        @endauth
    </a>

    {{-- Main Menu --}}
    <ul class="dropdown-menu main-menu {{ auth()->check() ? 'custom-dropdown-position' : 'custom-dropdown-position-guest' }}"
        data-bs-display="static">
        {{-- Dropdown Menu only for Logged In User --}}
        @auth
            {{-- Dashboard --}}
            @can('admin')
                <li>
                    <a class="dropdown-item d-flex" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-layout-text-sidebar-reverse me-2"></i> @lang('navbar.my_dashboard')
                    </a>
                </li>
            @endcan

            {{-- Cart --}}
            @if (!auth()->user()->is_admin)
                <li class="nav-item">
                    <a class="dropdown-item d-flex {{ Request::is('carts*') ? 'active' : '' }}"
                        href="{{ route('carts.index') }}">
                        <i class="bi bi-cart3 me-2"></i> @lang('navbar.cart')
                    </a>
                </li>
            @endif

            {{-- Chat --}}
            <li>
                <a class="dropdown-item d-flex {{ Request::is('chats*') ? 'active' : '' }}"
                    href="{{ route('chats.index') }}">
                    <i class="bi bi-chat-dots me-2"></i> @lang('navbar.chat')
                </a>
            </li>

            {{-- Profile --}}
            <li>
                <a class="dropdown-item d-flex {{ Request::is('users*') ? 'active' : '' }}"
                    href="{{ route('users.index') }}">
                    <i class="bi bi-person-circle me-2"></i> @lang('navbar.profile')
                </a>
            </li>

            <hr class="dropdown-divider">

            {{-- Subscriptions --}}
            @if (!auth()->user()->is_admin)
                <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:void(0)"
                        id="subscriptions-button">
                        <div class="d-inline-flex">
                            <i class="bi bi-envelope me-2"></i> @lang('navbar.subscriptions')
                        </div>
                        <div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </a>
                </li>
                <hr class="dropdown-divider">
            @endif

            {{-- Orders --}}
            @if (!auth()->user()->is_admin)
                <li>
                    <a class="dropdown-item d-flex {{ request()->routeIs('transactions.index') || request()->routeIs('transactions.show') ? 'active' : '' }}"
                        href="{{ route('transactions.index') }}">
                        <i class="bi bi-file-earmark-text me-2"></i> @lang('navbar.my_orders')
                    </a>
                </li>
            @else
                <li>
                    <a class="dropdown-item d-flex {{ request()->routeIs('transactions.orderRequest') ? 'active' : '' }}"
                        href="{{ route('transactions.orderRequest') }}">
                        <i class="bi bi-inbox me-2"></i> @lang('navbar.order_requests')
                    </a>
                </li>
            @endif

            <li>
                <hr class="dropdown-divider">
            </li>
        @endauth

        {{-- Dropdown Menu for All Users --}}
        {{-- Localization --}}
        <li>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:void(0)"
                id="localization-button">
                <div class="d-inline-flex">
                    <i class="bi bi-translate me-2"></i> @lang('navbar.language')
                </div>
                <div>
                    <i class="bi bi-chevron-right"></i>
                </div>
            </a>
        </li>
        {{-- Change Theme --}}
        <li>
            <a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:void(0)"
                id="color-theme-button">
                <div class="d-inline-flex">
                    <i class="bi bi-circle-half me-2"></i> @lang('navbar.theme')
                </div>
                <div>
                    <i class="bi bi-chevron-right"></i>
                </div>
            </a>
        </li>

        @auth
            <li>
                <hr class="dropdown-divider">
            </li>
            {{-- Logout --}}
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex">
                        <i class="bi bi-box-arrow-right me-2"></i> @lang('navbar.logout')
                    </button>
                </form>
            </li>
        @endauth
    </ul>

    {{-- Subscriptions Menu --}}
    @include('partials.subscriptions-menu')

    {{-- Localization Menu --}}
    @include('partials.localization-menu')

    {{-- Color Theme Menu --}}
    @include('partials.color-theme-menu')
</li>
