<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
        <!-- Logo -->
        <a class="fw-semibold text-dual">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-6 tracking-wider"> <img src="{{ asset('assets/media/logo.png') }}" alt="" srcset="" height="40px"> Umum & Personalia</span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div>

            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            @if (session()->get('username') == 'ea')
                <ul class="nav-main">
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="nav-main-link-icon si si-speedometer"></i>
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Route::currentRouteName() === 'bagian' ? 'active' : '' }}"
                            href="{{ route('bagian') }}">
                            <i class="nav-main-link-icon si si-menu"></i>
                            <span class="nav-main-link-name">Data Bagian</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Route::currentRouteName() === 'divisi' ? 'active' : '' }}"
                            href="{{ route('divisi') }}">
                            <i class="nav-main-link-icon si si-list"></i>
                            <span class="nav-main-link-name">Data Divisi</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Route::currentRouteName() === 'karyawan' || Route::currentRouteName() === 'karyawan.detail' ? 'active' : '' }}"
                            href="{{ route('karyawan') }}">
                            <i class="nav-main-link-icon si si-users"></i>
                            <span class="nav-main-link-name">Data Karyawan</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Route::currentRouteName() === 'riwayat' ? 'active' : '' }}"
                            href="{{ route('riwayat') }}">
                            <i class="nav-main-link-icon si si-calendar"></i>
                            <span class="nav-main-link-name">Riwayat Cuti</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Route::currentRouteName() === 'pengguna' ? 'active' : '' }}"
                            href="{{ route('pengguna') }}">
                            <i class="nav-main-link-icon si si-user"></i>
                            <span class="nav-main-link-name">Pengguna</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{route('logout')}}">
                            <i class="nav-main-link-icon si si-logout"></i>
                            <span class="nav-main-link-name">Logout</span>
                        </a>
                    </li>
                </ul>
            @else
                <ul class="nav-main">
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Route::currentRouteName() === 'karyawan' || Route::currentRouteName() === 'karyawan.detail' ? 'active' : '' }}"
                            href="{{ route('karyawan') }}">
                            <i class="nav-main-link-icon si si-users"></i>
                            <span class="nav-main-link-name">Data Karyawan</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{route('logout')}}">
                            <i class="nav-main-link-icon si si-logout"></i>
                            <span class="nav-main-link-name">Logout</span>
                        </a>
                    </li>
                </ul>
            @endif

        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
