<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu bg-pattern">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="#" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('images/kemendag-320.png') }}" alt="" height="10">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('images/kemendag-768.png') }}" alt="" height="40">
            </span>
        </a>
        <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('images/kemendag-320.png') }}" alt="" height="10">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('images/kemendag-768.png') }}" alt="" height="40">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                @php
                    $currentUrl = request()->url();
                    $parsedUrl = parse_url($currentUrl);
                    $pathSegments = explode('/', $parsedUrl['path']);
                    $firstSegment = '/' . $pathSegments[1];
                    if (count($pathSegments) >= 3) {
                        $secondSegment = $firstSegment . '/' . $pathSegments[2];
                    } else {
                        $secondSegment = $firstSegment;
                    }
                @endphp
                @if (isset($menuList))
                    @foreach ($menuList as $index => $menu)
                        @if (count($menu->child) > 0)
                            <a class="nav-link menu-link" href="#{{ $menu->code }}" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="bx bx-folder"></i> <span>{{ $menu->name }}</span>
                            </a>
                            @if (isset($menu->child))
                                @foreach ($menu->child as $index_j => $child)
                                    <div class="ms-2 collapse menu-dropdown @if ($firstSegment === $menu->url) show @endif"
                                        id="{{ $menu->code }}">
                                        <ul class="nav nav-lg flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route($child->url) }}"
                                                    class="nav-link @if ($secondSegment === $child->url) active @endif">
                                                    <i class="bx bx-subdirectory-right"></i>{{ $child->name }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link menu-link @if ($firstSegment === $menu->url) active @endif"
                                    href="{{ route($menu->url) }}">
                                    <i class="ri-home-2-line"></i> <span>{{ $menu->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
