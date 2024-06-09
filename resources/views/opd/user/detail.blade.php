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
                                    <h4>{{ ucwords($user->name) }} </h4>
                                    <div class="hstack gap-3 flex-wrap">
                                        <div class="text-muted">NIP :<span class="text-body fw-medium">
                                                {{ $user->nip }}</span></div>
                                        <div class="vr"></div>
                                        <div class="text-muted">NIK:<span class="text-body fw-medium">
                                                {{ $dataDiri->nik ?? '' }}</span></div>

                                        <div class="vr"></div>
                                        <div class="text-muted">No HP:<span class="text-body fw-medium">
                                                {{ $dataDiri->no_hp ?? '' }}</span></div>
                                    </div>
                                </div>
                            </div>
                            @if ($opd)
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                                        <i class="ri-government-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1">Unit Kerja/Instansi Daerah :</p>
                                                    <h5 class="mb-0 fs-16">{{ $opd->name ?? '' }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                            @endif
                            @if ($user->role->base === 'user')
                                <div class="product-content mt-3">
                                    <h5 class="fs-14 mb-3 text-info">Detail Data Pejabat Fungsional</h5>
                                    <nav>
                                        <ul class="nav nav-tabs nav-tabs-custom nav-success bg-light" id="nav-tab"
                                            role="tablist">
                                            @if ($dataDiri)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab"
                                                        href="#nav-speci" role="tab" aria-controls="nav-speci"
                                                        aria-selected="true">Data Diri</a>
                                                </li>
                                            @endif
                                            @if (count($pendidikan) > 0)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                        href="#nav-detail" role="tab" aria-controls="nav-detail"
                                                        aria-selected="false" tabindex="-1">Riwayat Pendidikan</a>
                                                </li>
                                            @endif
                                            @if (count($jabatan) > 0)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                        href="#jabatan" role="tab" aria-controls="nav-detail"
                                                        aria-selected="false" tabindex="-1">Riwayat Jabatan</a>
                                                </li>
                                            @endif
                                            @if (count($pangkat) > 0)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                        href="#pangkat" role="tab" aria-controls="nav-detail"
                                                        aria-selected="false" tabindex="-1">Riwayat Pangkat</a>
                                                </li>
                                            @endif
                                            {{-- @if ($kinerja)
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#kinerja"
                                                    role="tab" aria-controls="nav-detail" aria-selected="false"
                                                    tabindex="-1">Riwayat Kinerja</a>
                                            </li>
                                        @endif --}}
                                            @if (count($kompetensi) > 0)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                        href="#kompentensi" role="tab" aria-controls="nav-detail"
                                                        aria-selected="false" tabindex="-1">Riwayat Kompentensi</a>
                                                </li>
                                            @endif
                                            @if (count($sertifikasi) > 0)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                        href="#sertifikasi" role="tab" aria-controls="nav-detail"
                                                        aria-selected="false" tabindex="-1">Riwayat Sertifikasi</a>
                                                </li>
                                            @endif
                                            {{-- @if ($ukom)
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                    href="#nav-detail" role="tab" aria-controls="nav-detail"
                                                    aria-selected="false" tabindex="-1">Riwayat Ukom</a>
                                            </li>
                                        @endif --}}
                                        </ul>
                                    </nav>
                                    <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                        @if ($dataDiri)
                                            <div class="tab-pane fade show active" id="nav-speci" role="tabpanel"
                                                aria-labelledby="nav-speci-tab">
                                                <div class="table-responsive">
                                                    @include('opd.user.dataDiri')
                                                </div>
                                            </div>
                                        @endif
                                        @if (count($pendidikan) > 0)
                                            <div class="tab-pane fade" id="nav-detail" role="tabpanel"
                                                aria-labelledby="nav-detail-tab">
                                                <div>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">No</th>
                                                                <th scope="col">Tingkat</th>
                                                                <th scope="col">Jurusan</th>
                                                                <th scope="col">Instansi Pendidikan</th>
                                                                <th scope="col">Bulan-Tahun Kelulusan</th>
                                                                <th scope="col">FIle Ijazah</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; ?>
                                                            @foreach ($pendidikan as $item)
                                                                <tr>
                                                                    <td scope="col">{{ $no++ }}</td>
                                                                    <td scope="col">{{ $item->level ?? '' }}</td>
                                                                    <td scope="col">{{ $item->jurusan ?? '' }}</td>
                                                                    <td scope="col">
                                                                        {{ $item->instansi_pendidikan ?? '' }}
                                                                    </td>
                                                                    <td scope="col">
                                                                        {{ \Carbon\Carbon::parse($item->bulan_kelulusan ?? '')->format('M Y') }}
                                                                    </td>
                                                                    <td scope="col"><a
                                                                            href="{{ Storage::url($item->file_ijazah ?? '') }}"
                                                                            target="_blank">Lihat File <i
                                                                                class="mdi mdi-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                        @if (count($jabatan) > 0)
                                            <div class="tab-pane fade" id="jabatan" role="tabpanel"
                                                aria-labelledby="nav-detail-tab">
                                                <div class="table-responsive">
                                                    @include('opd.user.jabatan')
                                                </div>
                                            </div>
                                        @endif
                                        @if (count($pangkat) > 0)
                                            <div class="tab-pane fade" id="pangkat" role="tabpanel"
                                                aria-labelledby="nav-detail-tab">
                                                <div class="table-responsive">
                                                    @include('opd.user.pangkat')
                                                </div>
                                            </div>
                                        @endif
                                        {{-- @if ($kinerja)
                                        <div class="tab-pane fade" id="kinerja" role="tabpanel"
                                            aria-labelledby="nav-detail-tab">
                                            <div class="table-responsive">
                                                @include('opd.user.kinerja')
                                            </div>
                                        </div>
                                    @endif --}}
                                        @if (count($kompetensi) > 0)
                                            <div class="tab-pane fade" id="kompentensi" role="tabpanel"
                                                aria-labelledby="nav-detail-tab">
                                                <div class="table-responsive">
                                                    @include('opd.user.kompetensi')
                                                </div>
                                            </div>
                                        @endif
                                        @if (count($sertifikasi) > 0)
                                            <div class="tab-pane fade" id="sertifikasi" role="tabpanel"
                                                aria-labelledby="nav-detail-tab">
                                                <div class="table-responsive">
                                                    @include('opd.user.sertifikasi')
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
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
    <script src="{{ asset('build/js/pages/ecommerce-product-details.init.js') }}"></script>
@endsection
