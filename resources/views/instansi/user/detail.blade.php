@extends('layout.v_wrapper')
@section('title')
Detail User
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row gx-lg-5">

                <div class="col-xl-12">
                    <div class="mt-xl-0 mt-5">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>Dio </h5>
                                <div class="hstack gap-3 flex-wrap">
                                    <div class="text-muted">NIP : <span class="text-body fw-medium">Zoetic
                                        Fashion</span></div>
                                    <div class="vr"></div>
                                    <div class="text-muted">Unit Kerja/Instansi Daerah : <span class="text-body fw-medium">Zoetic
                                            Fashion</span></div>
                                    <div class="vr"></div>
                                    <div class="text-muted">No HP: <span class="text-body fw-medium">26 Mar,
                                            2021</span></div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div>
                                    <a href="apps-ecommerce-add-product" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit"><i class="ri-pencil-fill align-bottom"></i></a>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                                <i class="ri-money-dollar-circle-fill"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Unit Kerja/Instansi Daerah :</p>
                                            <h5 class="mb-0 fs-16">Dinas Perdagangan Nusa Tenggara Timur</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                                <i class="ri-money-dollar-circle-fill"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            foto
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <!-- end col -->
                        </div>







                        <div class="product-content mt-5">
                            <h5 class="fs-14 mb-3">Detail Data Pejabat Fungsional</h5>
                            <nav>
                                <ul class="nav nav-tabs nav-tabs-custom nav-success bg-light" id="nav-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci" role="tab" aria-controls="nav-speci" aria-selected="true">Data Diri</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false" tabindex="-1">Riwayat Pendidikan</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false" tabindex="-1">Riwayat Jabatan</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false" tabindex="-1">Riwayat Pangkat</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false" tabindex="-1">Riwayat Kinerja</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false" tabindex="-1">Riwayat Kompentensi</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false" tabindex="-1">Riwayat Sertifikasi</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false" tabindex="-1">Riwayat Ukom</a>
                                    </li>
                                </ul>
                            </nav>
                            <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                    <div class="table-responsive">
                                            @include('siap.adminSijupri.user.dataDiri')
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                    <div>
                                        <h5 class="font-size-16 mb-3">Tommy Hilfiger Sweatshirt for Men (Pink)</h5>
                                        <p>Tommy Hilfiger men striped pink sweatshirt. Crafted with cotton. Material
                                            composition is 100% organic cotton. This is one of the world’s leading
                                            designer lifestyle brands and is internationally recognized for
                                            celebrating the essence of classic American cool style, featuring preppy
                                            with a twist designs.</p>
                                        <div>
                                            <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                Machine Wash</p>
                                            <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                Fit Type: Regular</p>
                                            <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                100% Cotton</p>
                                            <p class="mb-0"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                Long sleeve</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product-content -->


                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>



<script src="/build/libs/swiper/swiper-bundle.min.js"></script>
<script src="{{asset('build/js/pages/ecommerce-product-details.init.js')}}"></script>

@endsection