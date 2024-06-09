@php
    $user = auth()->user();
@endphp

<body class="bg-white">
    <div id="layout-wrapper" class="">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header bg-pattern">
                    <div class="d-flex w-100">
                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger text-primary"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon text-primary fw-bold">
                                <span class="bg-primary text-primary fw-bold"></span>
                                <span class="bg-primary text-primary fw-bold"></span>
                                <span class="bg-primary text-primary fw-bold"></span>
                            </span>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-md-block" style="width: 100%;">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                                    id="search-options" value="">
                                <span class="mdi mdi-magnify search-widget-icon"></span>
                                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                                    id="search-close-options"></span>
                            </div>
                            <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                                <div data-simplebar style="max-height: 320px;">
                                    @if (isset($menuList))
                                        @foreach ($menuList as $index => $menu)
                                            @if (count($menu->child) > 0)
                                                @if (isset($menu->child))
                                                    @foreach ($menu->child as $index_j => $child)
                                                        <a href="{{ route($child->url) }}"
                                                            class="dropdown-item notify-item">
                                                            <i
                                                                class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                                            <span>{{ $menu->name . ' / ' . $child->name }}</span>
                                                        </a>
                                                    @endforeach
                                                @endif
                                            @else
                                                <a href="{{ route($menu->url) }}" class="dropdown-item notify-item">
                                                    <i
                                                        class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                                    <span>{{ $menu->name }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex align-items-center ">
                        <!-- ... (previous code) ... -->
                        <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                            <button type="button" class="btn btn-icon btn-topbar  rounded-circle"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-bell fs-22 text-primary fw-bold'></i>
                                <span id="main-notification-count"
                                    class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="dropdown-head bg-light bg-pattern rounded-top">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold text-grey"> Pemberitahuan</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content position-relative" id="notificationItemsTabContent">
                                    <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                        <div id="main-notification" data-simplebar style="max-height: 300px;"
                                            class="pe-2">
                                            <div
                                                class="text-reset notification-item d-block dropdown-item position-relative">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3 flex-shrink-0">
                                                        <span
                                                            class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">
                                                            <i class='bx bx-message-square-dots'></i>
                                                        </span>
                                                    </div>
                                                    <span class="text-info"> Tidak Ada Pengumuman</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown ms-sm-1 header-item topbar-user bg-pattern">
                                <button type="button" class="btn" id="page-header-user-dropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="d-flex align-items-center">
                                        {{-- <img class="rounded-circle header-profile-user"
                                            src="{{ asset('images/avatar-1.jpg') }}" alt="Header Avatar"> --}}
                                        <i class="ri-user-line text-primary fw-bold fs-20"></i>
                                        <span class="text-start ms-xl-2">
                                            {{ strlen($user->name) > 6 ? substr($user->name, 0, 7) . '...' : $user->name }}
                                        </span>
                                    </span>
                                </button>
                                <div class=" dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <h6 class="dropdown-header">name : {{ $user->name }}</h6>
                                    <h6 class="dropdown-header">role : {{ $user->role->name }}</h6>
                                    @if ($user->role->base == 'user')
                                        <a type="submit" class="dropdown-item text-primary"
                                            href="{{ route('/profile/detail') }}">
                                            <i class="ri-user-line font-size-16 align-middle me-1"></i>
                                            <span key="t-logout">Profile</span>
                                        </a>
                                    @endif
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bx bx-power-off font-size-16 align-middle me-1"></i>
                                            <span key="t-logout">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </header>
        @section('notification')
            <script>
                function fetchNotifications() {
                    $.ajax({
                        url: '/message/notification',
                        method: 'GET',
                        success: function(response) {
                            $('#main-notification').empty();
                            if (response.length === 0) {
                                $('#main-notification-count').text('');
                                var noNotification = $(
                                    '<div class="text-reset notification-item d-block dropdown-item position-relative">' +
                                    '<div class="d-flex">' +
                                    '<div class="avatar-xs me-3 flex-shrink-0">' +
                                    '<span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">' +
                                    '<i class="bx bx-message-square-dots"></i>' +
                                    '</span>' +
                                    '</div>' +
                                    '<span class="text-info"> Tidak Ada Pengumuman</span>' +
                                    '</div>' +
                                    '</div>');
                                $('#main-notification').append(noNotification);
                            } else {
                                response.forEach(function(notification) {
                                    var newNotification = $(
                                        '<div class="text-reset notification-item d-block dropdown-item position-relative">' +
                                        '<div class="d-flex">' +
                                        '<div class="avatar-xs me-3 flex-shrink-0">' +
                                        '<span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">' +
                                        '<i class="bx bx-message-square-dots"></i>' +
                                        '</span>' +
                                        '</div>' +
                                        '<div class="flex-grow-1">' +
                                        '<a href="#" class="stretched-link">' +
                                        (notification.type == "ANNOUNCEMENT" ?
                                            '<a href="/pengumuman/daftar/' + notification.content_id +
                                            '" class="stretched-link">' :
                                            '<a href="/pesan" class="stretched-link">') +
                                        '<h6 class="mt-0 mb-2 fs-13 lh-base">' +
                                        '<b class="text-success">' + notification.type + '</b>' +
                                        '<p>' + notification.title + '</p>' +
                                        '</h6>' +
                                        '</a>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>');
                                    $('#main-notification-count').text(response.length);
                                    $('#main-notification').append(newNotification);
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching notifications:', error);
                        }
                    });
                }

                setInterval(fetchNotifications, 5000);
            </script>
        @endsection
