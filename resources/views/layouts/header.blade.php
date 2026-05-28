<link rel="stylesheet" href="{{ asset('assets/css/layouts.css') }}">

<header class="app-header">

    <nav class="navbar navbar-expand-lg navbar-light px-4">

        <ul class="navbar-nav me-3">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>

        <div>
            <h4 class="page-title">
                @yield('title')
            </h4>
        </div>

        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                <i class="ti ti-logout"></i>
                Logout
            </a>
        </div>

    </nav>

    <hr class="header-line">

</header>