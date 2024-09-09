@extends('layout.v_wrapper')
@section('title')
    Detail Pejabat Fungsional
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Detail Pejabat Fungsional
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('/user/user_jf/edit', ['nip' => $user->nip]) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <div class="row text-dark">
                                <div class="col-3"><b>Instansi</b></div>
                                <div class="col"><b>{{ $user->instansi->name ?? '-' }}</b></div>
                            </div>
                            @if ($user->instansi->provinsi_id ?? null)
                                <div class="row text-dark">
                                    <div class="col-3">Provinsi</div>
                                    <div class="col">{{ $user->instansi->provinsi->name ?? '-' }}</div>
                                </div>
                            @endif
                            @if ($user->instansi->kabupaten_id ?? null)
                                <div class="row text-dark">
                                    <div class="col-3">Provinsi</div>
                                    <div class="col">{{ $user->instansi->kabupaten->name ?? '-' }}</div>
                                </div>
                            @endif
                            @if ($user->instansi->kota_id ?? null)
                                <div class="row text-dark">
                                    <div class="col-3">Provinsi</div>
                                    <div class="col">{{ $user->instansi->kota->name ?? '-' }}</div>
                                </div>
                            @endif
                            <br>
                            <div class="row text-dark">
                                <div class="col-3">Unit Kerja</div>
                                <div class="col">{{ $user->unitKerja->name ?? '-' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Alamat Unit Kerja</div>
                                <div class="col">{{ $user->unitKerja->alamat ?? '-' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">NIP</div>
                                <div class="col">{{ $user->nip ?? '-' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">NIK</div>
                                <div class="col">{{ $userDetail->nik ?? '-' }}</div>
                            </div>
                            <hr>
                            <div class="row text-dark">
                                <div class="col-3">Nama</div>
                                <div class="col">{{ $user->name ?? '-' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Tempat, Tanggal Lahir</div>
                                <div class="col">
                                    {{ $userDetail->tempat_lahir ?? '-' }},
                                    {{ substr($userDetail->tanggal_lahir ?? '-', 0, 10) }}
                                </div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Jenis Kelamin</div>
                                <div class="col">{{ $userDetail->jenis_kelamin ?? '-' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Nomor Handphone/WA</div>
                                <div class="col">{{ $userDetail->no_hp ?? '-' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Alamat Email</div>
                                <div class="col">{{ $userDetail->email ?? '-' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">KTP</div>
                                <div class="col">
                                    <a class="link-info" href="javascript:void(0);"
                                        onclick="previewModal({{ json_encode($userDetail->file_ktp ?? '-') }}, 'KTP')">
                                        Lihat <i class=" las la-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="Status" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Status
                                    </label>
                                    <select id="user_status" name="user_status" class="form-control">
                                        <option value="ACTIVE" {{ $user->user_status == 'ACTIVE' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="NOT_ACTIVE"
                                            {{ $user->user_status == 'NOT_ACTIVE' ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-sm btn-danger" name="delete_flag" value="true">
                                    Hapus
                                </button>
                                <button type="submit" class="btn btn-sm btn-info">Ubah</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!--end col-->
        <div class="card">
            <div class="card-header justify-content-center d-flex bg-body-tertiary">
                <style>
                    .overflow-auto {
                        overflow-x: auto;
                        white-space: nowrap;
                        height: 100px;
                    }
                </style>
                <div class="overflow-auto">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0 flex-nowrap mt-3"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#Pendidikan" role="tab">
                                <i class=" las la-user-graduate"></i>
                                Riwayat Pendidikan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Jabatan" role="tab">
                                <i class=" las la-sort-up"></i>
                                Riwayat Jabatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Pangkat" role="tab">
                                <i class=" las la-star"></i>
                                Riwayat Pangkat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kompetensi" role="tab">
                                <i class=" las la-chart-area"></i>
                                Riwayat Kompentesi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#sertifikasi" role="tab">
                                <i class=" las la-chart-area"></i>
                                Riwayat Sertifikasi
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="Pendidikan" role="tabpanel">
                        @include('user.verifikasi_sijupri.riwayat_pendidikan')
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="Jabatan" role="tabpanel">
                        @include('user.verifikasi_sijupri.riwayat_jabatan')
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="Pangkat" role="tabpanel">
                        @include('user.verifikasi_sijupri.riwayat_pangkat')
                    </div>
                    <div class="tab-pane" id="kompetensi" role="tabpanel">
                        @include('user.verifikasi_sijupri.riwayat_kompetensi')
                    </div>
                    <div class="tab-pane" id="sertifikasi" role="tabpanel">
                        @include('user.verifikasi_sijupri.riwayat_sertifikasi')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('widget.modal-doc')
    <!--end row-->
@endsection
