<li class="menu-title"><span>SIAP</span></li>
<li class="nav-item">
    <a class="nav-link menu-link" href="{{ route('dashboard.instansi') }}">
        <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="sidebarApps">
        <i class="ri-apps-2-line"></i> <span>Unit Kerja/Instansi Daerah</span>
    </a>
    <div class="collapse menu-dropdown" id="sidebarApps">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('siap.unit_kerja') }}" class="nav-link">
                    Data Unit Kerja/Instansi Daerah</a>

            </li>
            <li class="nav-item">
                <a href="{{ route('siap.admin.pengelola') }}" class="nav-link">
                    Data Admin Unit Kerja/Instansi Daerah</a>

            </li>


        </ul>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="{{ route('siap.user.external') }}">
        <i class="las la-user-alt"></i> <span>Pejabat Fungsional</span>
    </a>
</li>