<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box ">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark ">
            <span class="logo-sm">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Logo_Kementerian_Perdagangan_Republik_Indonesia_%282021%29.svg" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Logo_Kementerian_Perdagangan_Republik_Indonesia_%282021%29.svg" alt="" height="40" width="200">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Logo_Kementerian_Perdagangan_Republik_Indonesia_%282021%29.svg" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Logo_Kementerian_Perdagangan_Republik_Indonesia_%282021%29.svg" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Menu</span></li>
                @if (auth()->user()->role_code == 'super_admin')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard.sijupri') }}">
                        <i class="ri-home-2-line"></i> <span>Home</span>
                    </a>
                </li>
                <li class="menu-title"><span>SIAP</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAppsSiap" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>Data User</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAppsSiap">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('siap.user.external') }}" class="nav-link">Data User JF
                                    External</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/ukom/periode" class="nav-link">Data User JF Internal</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAppsAdmin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>Data Admin</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAppsAdmin">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('siap.admin.sijupri') }}" class="nav-link">Admin SiJUpri</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('siap.admin.instansi') }}" class="nav-link">Admin Instansi</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('siap.admin.pengelola') }}" class="nav-link">Admin Unit
                                    Unit Kerja/Instansi Daerah</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('siap.unit_kerja.list') }}">
                        <i class=" las la-building"></i> <span>Data Unit Kerja/Instansi Daerah</span>
                    </a>
                </li>
                <li class="nav-item">
                <li class="menu-title"><span>Modul</span></li>
                <a class="nav-link menu-link" href="#sidebarAppsADMIN" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                    <i class="ri-apps-2-line"></i> <span>UKOM</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarAppsADMIN">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="/admin/ukom/periode" class="nav-link">PERIODE UKOM</a>
                        </li>

                        <li class="menu-title"><span>UJIAN UKOM</span></li>
                        <li class="nav-item">

                            <a href="#sidebarUnitKerja" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUnitKerja">
                                Kenaikan Jenjang </a>
                            <div class="collapse menu-dropdown" id="sidebarUnitKerja">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="/admin/ukom/kenaikan-jenjang/baru" class="nav-link">Baru </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/admin/ukom/kenaikan-jenjang/mengulang" class="nav-link">
                                            Mengulang </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAppPerformanceReview" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                            <i class="ri-apps-2-line"></i> <span>Performance Review</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAppPerformanceReview">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="/admin/ukom/kenaikanjenjang" class="nav-link">
                                        Home </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/ukom/kenaikan-jenjang/baru" class="nav-link">Baru </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/pr/home" class="nav-link">Pengamat</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/pr/home" class="nav-link">Pengamat Tera</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </div>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#Formasi" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Formasi">
                        <i class="ri-apps-2-line"></i> <span>Formasi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="Formasi">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('/formasi/data_rekomendasi_formasi') }}" class="nav-link">
                                    Data Formasi
                                </a>
                            </li>
                    </div>
                </li>

                @endif
                @if (auth()->user()->role->base == 'user')
                @include('layout.nav.user')
                @endif
                @if (auth()->user()->role->base == 'admin_instansi')
                @include('layout.nav.instansi')
                @endif
                @if (auth()->user()->role->base == 'pengatur_siap')
                @include('layout.nav.opd')
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->