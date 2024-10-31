@extends('layout.master-without-nav')
@section('title')
    Landing
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    @include('layout.css_select')
@endsection
@section('content')
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top bg-white" id="navbar">
        <div class="container">
            <a href="#" class="logo logo-dark ">
                <span class="logo-sm">
                    <img src="{{ asset('images/kemendag-320-bg.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('images/kemendag-768-bg.png') }}" alt="" height="40">
                </span>
            </a>
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('images/kemendag-320.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('images/kemendag-768.png') }}" alt="" height="40">
                </span>
            </a>
            <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="w-100">
                    <ul class="navbar-nav mt-2 mt-lg-0 float-end" id="navbar-example">
                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#ukom">Pendaftaran UKom</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Lokasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-soft-primary mt-2" href="{{ route('login') }}">Masuk</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="vertical-overlay" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent.show"></div>
    <section class="section pb-5 hero-section" id="home">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-sm-10">
                    <div class="text-center mt-lg-5 pt-5">
                        <h1 class="display-6 fw-semibold mb-3 lh-base">
                            Sistem Informasi Jabatan Fungsional Perdagangan Republik Indonesia
                            <span class="text-primary">SIJuPRI</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 1440 120">
                <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                    <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                    </path>
                </g>
            </svg>
        </div>
    </section>
    <div class="pt-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-5">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="section bg-light" id="ukom">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="d-flex align-items-center text-black w-100 card">
                <h3 class="mb-3 fw-semibold mt-2">Pendaftaran UKom</h3>
            </div>
            <div class="row">
                <div class="col mb-2">
                    <div class="card card-animate plan-box mb-0">
                        <div class="card-body p-4 m-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-semibold">UKom Internal</h5>
                                    <p class="text-muted mb-0">Khusus Internal Kemendag</p>
                                </div>
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle text-primary">
                                        <i class="ri-book-mark-line fs-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="mt-3">Dokumen Promosi</label>
                                <ul class="list-unstyled text-muted vstack gap-3 ff-secondary">
                                    @foreach ($filePersyaratanIntPromosi['values'] as $file)
                                        <li>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 text-success me-1">
                                                    <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $file }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <label class="mt-2">Dokumen Perpindahan Jabatan</label>
                                <ul class="list-unstyled text-muted vstack gap-3 ff-secondary">
                                    @foreach ($filePersyaratanIntPromosi['values'] as $file)
                                        <li>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 text-success me-1">
                                                    <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $file }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-4">
                                    <a href="{{ route('/page/ukom/internal') }}" class="btn btn-soft-primary w-100">
                                        Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-2">
                    <div class="card card-animate plan-box mb-0">
                        <div class="card-body p-4 m-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-semibold">UKom External</h5>
                                    <p class="text-muted mb-0">Khusus External Kemendag</p>
                                </div>
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle text-primary">
                                        <i class="ri-book-mark-line fs-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="mt-3">Dokumen Promosi</label>
                                <ul class="list-unstyled text-muted vstack gap-3 ff-secondary">
                                    @foreach ($filePersyaratanExtPromosi['values'] as $file)
                                        <li>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 text-success me-1">
                                                    <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $file }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <label class="mt-2">Dokumen Perpindahan Jabatan</label>
                                <ul class="list-unstyled text-muted vstack gap-3 ff-secondary">
                                    @foreach ($filePersyaratanExtPromosi['values'] as $file)
                                        <li>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 text-success me-1">
                                                    <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $file }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-4">
                                    <a href="{{ route('/page/ukom/external') }}" class="btn btn-soft-primary w-100">
                                        Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-2">
                    <div class="card card-animate plan-box mb-0">
                        <div class="card-body p-4 m-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-semibold">Detail Pendaftaran</h5>
                                    <p class="text-muted mb-0">Detail Pendaftaran dan Perbaikan Dokumen</p>
                                </div>
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle text-primary">
                                        <i class="ri-book-mark-line fs-20"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="mt-3 text-black" style="text-align: justify">
                                    Anda dapat melihat detail dan memper-baiki dokumen pendaftaran UKom anda dnegan
                                    melakukan
                                    scan QR yang telah anda download atau dengan menginput- kan kode pendaftaran dibawah ini
                                </p>
                                <form id="ukomForm" method="GET" action="/page/ukom/">
                                    <input id="pendaftaran_code" class="form-control" type="text">
                                    <button type="submit" class="btn btn-soft-secondary w-100 mt-4">kirim</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section" id="contact">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="text-center mb-5 w-100">
                    <h3 class="mb-3 fw-semibold">Lokasi</h3>
                    <p class="text-muted mb-4 ff-secondary"></p>

                    <iframe class="w-75 h-100"
                        src="https://maps.google.com/maps?q=Kementerian+Perdagangan+Republik+Indonesia%2C+Jl.+M.I.+Ridwan+Rais%2C+RT.7%2FRW.1%2C+Gambir%2C+Kecamatan+Gambir%2C+Kota+Jakarta+Pusat%2C+Daerah+Khusus+Ibukota+Jakarta+10110&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                        style="border: 1px solid #007bff;"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    @include('layout.js_select')
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/landing.init.js') }}"></script>
    <script>
        function limitLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
        },
        function validateLength(input) {
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var pendaftaranCodeInput = document.getElementById("pendaftaran_code");
            pendaftaranCodeInput.addEventListener("input", function() {
                var ukomForm = document.getElementById("ukomForm");
                var inputValue = pendaftaranCodeInput.value;
                ukomForm.action = "/page/ukom/" + inputValue;
            });
        });
    </script>
@endsection
