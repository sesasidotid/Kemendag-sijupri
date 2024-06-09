<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>SIjuPRI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/binboot.jpg') }}">
    @include('layout.head-css')
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">
    @php
        setlocale(LC_TIME, 'id_ID.UTF-8');
    @endphp
    <div class="layout-wrapper landing">
        @yield('content')
        <footer class="custom-footer bg-dark py-5 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mt-4">
                        <div>
                            <div>
                                <img src="{{ asset('images/kemendag-768-bg.png') }}" alt="logo light" height="50">
                            </div>
                            <div class="mt-4 fs-13">
                                <p>Admin, Dashboard & pages SIjuPRI</p>
                                <p class="ff-secondary">
                                    Sistem Informasi Pendataan Pejabat Fungsional Seluruh Indonesia
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 ms-lg-auto">
                        <div class="row">
                            <div class="col-sm-4 mt-4">
                                <h5 class="text-white mb-0">Kemendag RI</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list">
                                        <li><a href="javascript: void(0);">Tentang Kami</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-4">
                                <h5 class="text-white mb-0">Aplikasi</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list mb-0 mt-0 p-0">
                                        <li><a href="javascript: void(0);">Siap</a></li>
                                    </ul>
                                    <ul class="list-unstyled ff-secondary footer-list mb-0 mt-0 p-0">
                                        <li><a href="javascript: void(0);">Formasi</a></li>
                                    </ul>
                                    <ul class="list-unstyled ff-secondary footer-list mb-0 mt-0 p-0">
                                        <li><a href="javascript: void(0);">AKP</a></li>
                                    </ul>
                                    <ul class="list-unstyled ff-secondary footer-list mb-0 mt-0 p-0">
                                        <li><a href="javascript: void(0);">Kinerja</a></li>
                                    </ul>
                                    <ul class="list-unstyled ff-secondary footer-list mb-0 mt-0 p-0">
                                        <li><a href="javascript: void(0);">UKom</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-4">
                                <h5 class="text-white mb-0">Bantuan</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list">
                                        <li><a href="javascript: void(0);">-</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center text-sm-start align-items-center mt-5">
                    <div class="col-sm-6">
                        <div>
                            <p class="copy-rights mb-0">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                Â© SESASI - CV
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end mt-3 mt-sm-0">
                            <ul class="list-inline mb-0 footer-social-link">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-facebook-fill"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://instagram.com/pusbinjfdag" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-instagram-fill"></i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
    </div>

    @include('layout.vendor-scripts')
</body>

</html>
