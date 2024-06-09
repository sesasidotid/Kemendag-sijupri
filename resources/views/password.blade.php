<!doctype html>
<html lang="en" data-topbar="light" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title> SIjuPRI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/binboot.jpg') }}">
    <!-- Layout config Js -->
    <script src="{{ asset('build/js/layout.js') }}"></script>
    <link href="{{ asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('build/css/custom.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>
<!-- auth-page wrapper -->
<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <!-- auth-page content -->
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class=" overflow-hidden">
                        <div class="row justify-content-center ">
                            <div class="col-lg-8 card shadow-lg p-2">
                                <div class="p-lg-5 ">
                                    <h5 class="text-primary">BUAT KATA SANDI BARU</h5>
                                    <div class="alert alert-danger" role="alert">
                                        <strong> Anda perlu membuat kata sandi baru! </strong> Silahkan isi form di
                                        bawah.
                                    </div>
                                    <div class="">
                                        <form method="POST" action="{{ route('siap.password') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input name="password" type="password"
                                                        class="form-control pe-5 password-input" onpaste="return true"
                                                        placeholder="Enter password" id="password-input"
                                                        aria-describedby="passwordInput"
                                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required />
                                                    <button
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                        type="button" id="password-addon"><i
                                                            class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                                <div id="passwordInput" class="form-text">Must be at least 8 characters.
                                                </div>
                                            </div>

                                            {{-- <div class="mb-3">
                                                <label class="form-label" for="confirm-password-input">Confirm
                                                    Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5 password-input"
                                                        onpaste="return true" placeholder="Confirm password"
                                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                        id="confirm-password-input" required />
                                                    <button
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                        type="button" id="confirm-password-input"><i
                                                            class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div> --}}
                                            <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                <h5 class="fs-13">Password must contain:</h5>
                                                <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8
                                                        characters</b></p>
                                                <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter
                                                    (a-z)</p>
                                                <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b>
                                                    letter (A-Z)</p>
                                                <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b>
                                                    (0-9)</p>
                                            </div>


                                            <div class="mt-4">
                                                <button class="btn btn-secondary w-100" type="submit">Reset
                                                    Password</button>
                                            </div>

                                        </form>
                                    </div>


                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0">&copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> SIjuPRI. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Themesbrand
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

<script src="{{ asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('build/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('build/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('build/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('build/js/plugins.js') }}"></script>
<script src="{{ asset('build/js/pages/passowrd-create.init.js') }}"></script>
</body>

</html>
