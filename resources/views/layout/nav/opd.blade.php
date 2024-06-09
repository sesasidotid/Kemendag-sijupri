<li class="nav-item">
    <a class="nav-link menu-link" href="{{ route('dashboard.unitkerjaOpd') }}">
        <i class="ri-home-2-line"></i> <span>Home</span>
    </a>
</li>

<li class="menu-title"><span>SIAP</span></li>


<li class="nav-item">
    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="sidebarApps">
        <i class="las la-user-alt"></i> <span>Pejabat Fungsional</span>
    </a>
    <div class="collapse menu-dropdown" id="sidebarApps">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{ route('siap.user.external') }}">
                    <span>Data Pejabat Fungsional</span>
                </a>
                <a class="nav-link menu-link" href="{{ route('/task/user_jf') }}">
                    <span>Verifikasi</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="menu-title"><span>MODUL</span></li>

<li class="nav-item">
    <a class="nav-link menu-link" href="#Formasi" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="Formasi">
        <i class="ri-apps-2-line"></i> <span>Formasi</span>
    </a>
    <div class="collapse menu-dropdown" id="Formasi">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('/formasi/jabatan') }}" class="nav-link">
                    Data Formasi
                </a>
            </li>
    </div>
</li>
