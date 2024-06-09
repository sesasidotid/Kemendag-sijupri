@extends('layout.v_wrapper')
@section('title')
Dashboard
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
<div class="row">
    <!--end col-->
    <div class="col-md-12 ">
        <div class="alert alert-success " role="alert">
            <strong class="font-20">Welcome !</strong>Sistem Informasi Pejabat Fungsional!
        </div>
        <div class="card  ">
            <div class="card-header justify-content-center d-flex bg-body-tertiary">
                <ul class=" nav font-25 nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link "  href="/admin/sijupri/dashboard/opd" >
                            <i class=" las la-user-alt"></i>
                            Data Unit Kerja/Instansi Daerah
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/sijupri/dashboard/formasi" >
                            <i class=" las la-user-graduate"></i>
                           Data Formasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Jabatan" role="tab">
                            <i class=" las la-sort-up"></i>
                            Data User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Pangkat" role="tab">

                            <i class=" las la-star"></i>
                            AKP
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#PAK" role="tab">
                            <i class=" las la-chart-area"></i>
                            FORMASI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kompetensi" role="tab">
                            <i class=" las la-chart-area"></i>
                            Performance Review
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#sertifikasi" role="tab">
                            <i class=" las la-chart-area"></i>
                       Data KL
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ukom" role="tab">
                            <i class=" las la-chart-area"></i>
                         UKOM
                        </a>
                    </li>

                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">

                    <div class="tab-pane active " id="userDetail" role="tabpanel">
                        <div class="card-body">
                            <div class="card-header  bg-light mb-2 ">
                                <h4 class="text-center">Data Formasi</h4>
                            </div>


                        </div>
                        <div class="card-body">
                            <div class="card-header  bg-light mb-2 ">
                                <h4 class="text-center">Data Formasi</h4>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                @include('siap.adminSijupri.verifikasiUser.index')
                            </div>
                        </div>

                    </div>
                    <!--end tab-pane-->

                    <!--end tab-pane-->
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

{{-- @endsection --}}