@extends('layout.v_wrapper')
@section('title')
    Data Unit Kerja/Instansi Daerah
@endsection
@section('ext_heeder')
    @include('layout.css_select')
@endsection
@push('ext_footer')
    @include('layout.js_select')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div>
                    <form wire:submit.prevent="store">
                        <div class="row">
                            @if (isset($unitKerja->instansi->provinsi))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Provinsi" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Provinsi
                                        </label>
                                        <input type="text" class="form-control" id="Provinsi" disabled
                                            value="{{ $unitKerja->instansi->provinsi->name }}">
                                    </div>
                                </div>
                            @endif
                            @if (isset($unitKerja->instansi->kabupaten))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Kabupaten" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Kabupaten
                                        </label>
                                        <input type="text" class="form-control" id="Kabupaten" disabled
                                            value="{{ $unitKerja->instansi->kabupaten->name }}">
                                    </div>
                                </div>
                            @endif
                            @if (isset($unitKerja->instansi->kota))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Kota" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Kota
                                        </label>
                                        <input type="text" class="form-control" id="Kota" disabled
                                            value="{{ $unitKerja->instansi->kota->name }}">
                                    </div>
                                </div>
                            @endif
                            @if (isset($unitKerja->name))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="NamaUnitKerja" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Nama Unit Kerja
                                        </label>
                                        <input type="text" class="form-control" id="NamaUnitKerja" disabled
                                            value="{{ $unitKerja->name }}">
                                    </div>
                                </div>
                            @endif
                            @if (isset($unitKerja->nip))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="NIP" class="form-label">
                                            <span class="text-danger fw-bold">*</span> NIP
                                        </label>
                                        <input type="text" class="form-control" id="NIP" disabled
                                            value="{{ $unitKerja->nip }}">
                                    </div>
                                </div>
                            @endif
                            @if (isset($user->name))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Nama" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Nama
                                        </label>
                                        <input type="text" class="form-control" id="Nama" disabled
                                            value="{{ $user->name }}">
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="NIK" class="form-label">
                                        <span class="text-danger fw-bold">*</span> NIK
                                    </label>
                                    <input wire:model="request.nik" type="text"
                                        class="form-control @error('request.nik') is-invalid @enderror" id="NIK"
                                        placeholder="Masukkan NIK">
                                    @error('request.nik')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="JenisKelamin" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Jenis Kelamin
                                    </label>
                                    <select wire:model="request.jenis_kelamin" class="form-select mb-3"
                                        aria-label="JenisKelamin" id="JenisKelamin">
                                        <option selected>Pilih Jenis Kelamin</option>
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                    @error('request.jenis_kelamin')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="AlamatEmail" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Alamat Email
                                    </label>
                                    <input wire:model="request.email" type="email"
                                        class="form-control @error('request.email') is-invalid @enderror" id="AlamatEmail"
                                        placeholder="Enter your email">
                                    @error('request.email')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="NoHandphone" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Nomor Handphone
                                    </label>
                                    <input wire:model="request.no_hp" type="text"
                                        class="form-control @error('request.no_hp') is-invalid @enderror" id="NoHandphone"
                                        placeholder="Masukkan Nomor Handphone">
                                    @error('request.no_hp')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="TempatLahir" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Tempat Lahir
                                    </label>
                                    <input wire:model="request.tempat_lahir" type="text"
                                        class="form-control @error('request.tempat_lahir') is-invalid @enderror"
                                        id="TempatLahir" placeholder="Masukkan Tempat Lahir" />
                                    @error('request.tempat_lahir')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="TanggalLahir" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Tanggal Lahir
                                    </label>
                                    <input wire:model="request.tanggal_lahir" type="date" data-provider="flatpickr"
                                        class="form-control @error('request.tanggal_lahir') is-invalid @enderror"
                                        id="TanggalLahir" data-date-format="d M, Y" data-deafult-date="24 Nov, 2021"
                                        placeholder="Pilih Tanggak Lahir" />
                                    @error('request.tanggal_lahir')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="FileKTP" class="form-label">
                                        <span class="text-danger fw-bold">*</span> File KTP
                                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                    </label>
                                    <input wire:model="request.file_ktp" type="file" accept=".pdf"
                                        class="form-control @error('request.file_ktp') is-invalid @enderror"
                                        id="FileKTP" />
                                    @error('request.file_ktp')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
