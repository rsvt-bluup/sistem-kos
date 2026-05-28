<link rel="stylesheet" href="{{ asset('assets/css/layouts.css') }}">

<aside class="left-sidebar" style="top:0; background:#fff;">

    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">

            <a href="{{ route('dashboard') }}"
                class="text-nowrap logo-img text-decoration-none">
                <h3 class="fw-bold m-0" style="color: #28557d;">
                    KosKu
                </h3>
            </a>

            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>

        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <li class="nav-small-cap mt-3">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">
                        MENU UTAMA
                    </span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="ti ti-layout-dashboard"></i>
                        <span class="hide-menu">
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('kamar.*') ? 'active' : '' }}" href="{{ route('kamar.index') }}" aria-expanded="false">
                        <i class="ti ti-door"></i>
                        <span class="hide-menu">
                            Data Kamar
                        </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('penyewa.*') ? 'active' : '' }}" href="{{ route('penyewa.index') }}" aria-expanded="false">
                        <i class="ti ti-users"></i>
                        <span class="hide-menu">
                            Data Penyewa
                        </span>
                    </a>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}" href="{{ route('pembayaran.index') }}" aria-expanded="false">
                        <i class="ti ti-credit-card"></i>
                        <span class="hide-menu">
                            Pembayaran
                        </span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>