@include('layout.v_head')
@include('layout.v_headNav')
@include('layout.v_nav')
<div class="vertical-overlay"></div>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content bg-white">
    <div class="bg-overlay bg-overlay-pattern"></div>
    <div id="page-content-parent" class="page-content d-flex justify-content-center align-items-center"
        style="min-height: 100vh;">
        <div id="page-loading" class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div id="page-content" class="container-fluid" style="display: none">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0 font-size-20 fw-bolder">@yield('title')</h3>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <div class="card p-1">
                                    @if (request()->route()->uri() != 'dashboard')
                                        <div>
                                            <a class="btn btn-sm btn-soft-light me-1 ms-1 "
                                                href="{{ route('/dashboard') }}">
                                                <span class="text-primary">Dashboard</span>
                                            </a>
                                            <span class="mt-1 ms-1 me-1">|</span>
                                            <button type="button" class="btn btn-default btn-circle btn-light"
                                                onclick="backToPreviousUrl()">
                                                <i class="ri-arrow-go-back-line text-primary h5"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <h1>TEST</h1> --}}
            @yield('content')
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @include('layout.v_footer')
