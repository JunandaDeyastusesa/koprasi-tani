<!-- Sidebar -->
@php
    $currentRouteName = Route::currentRouteName();
@endphp

<nav class="col-md-2 col-lg-2 d-md-block sidebar">
    <div class="sidebar-menu position-sticky pt-4">
        <div class="text-center mb-4">
            <img src="{{ asset('images/MPSI UTS Presentation 1.png') }}" alt="Logo" class="side-logo img-fluid">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ $currentRouteName == 'dashboard.index' ? 'active' : '' }}"
                    href="{{ route('dashboard.index') }}">
                    <i class="pe-2 fs-5 bi bi-grid"></i>
                    Dashboard
                </a>
            </li>
            @if (Auth::check() && Auth::user()->hasRole('member'))
                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'viewTransaksiMember' ? 'active' : '' }}"
                        href="{{ route('viewTransaksiMember') }}">
                        <i class="pe-2 fs-5 bi bi-credit-card-2-back-fill"></i>
                        Transaksi
                    </a>
                </li>
            @endif

            @if (Auth::check() && Auth::user()->hasRole('Admin'))
                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'inventaris.index' ? 'active' : '' }}"
                        href="{{ route('inventaris.index') }}">
                        <i class="pe-2 fs-5 bi bi-box-seam"></i>
                        Inventaris
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'mitras.index' ? 'active' : '' }}"
                        href="{{ route('mitras.index') }}">
                        <i class="pe-2 fs-5 bi bi-backpack4"></i>
                        Mitra
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'transaksi.index' ? 'active' : '' }}"
                        href="{{ route('transaksi.index') }}">
                        <i class="pe-2 fs-5 bi bi-credit-card-2-back-fill"></i>
                        Transaksi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'members.index' ? 'active' : '' }}"
                        href="{{ route('members.index') }}">
                        <i class="pe-2 fs-5 bi bi-backpack4"></i>
                        Member
                    </a>
                </li>
            @endif

        </ul>

    </div>
</nav>
