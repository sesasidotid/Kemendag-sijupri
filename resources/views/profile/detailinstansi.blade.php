@extends('layout.v_wrapper')
@section('title')
    Profil
@endsection
@section('content')
    <div class="row">
        <!--end col-->
        <div class="col-md-12">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                </div>
                <div class="p-2">
                    <form method="POST" action="{{ route('/profile/instansi') }}">
                        @csrf
                        <div class="row">
                            @if (isset($user->unitKerja->name) && $user->unit_kerja_id != null)
                                @if ($user->instansi->provinsi_id != null)
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="NamaUnitKerja" class="form-label">
                                                <span class="text-danger fw-bold">*</span> Provinsi
                                            </label>
                                            <input type="text" class="form-control" id="NamaUnitKerja" disabled
                                                value="{{ $user->instansi->provinsi->name }}">
                                        </div>
                                    </div>
                                @endif
                                @if ($user->instansi->kabupaten_id != null)
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="NamaUnitKerja" class="form-label">
                                                <span class="text-danger fw-bold">*</span> Kabupaten
                                            </label>
                                            <input type="text" class="form-control" id="NamaUnitKerja" disabled
                                                value="{{ $user->instansi->kabupaten->name }}">
                                        </div>
                                    </div>
                                @endif
                                @if ($user->instansi->kota_id != null)
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="NamaUnitKerja" class="form-label">
                                                <span class="text-danger fw-bold">*</span> Kota
                                            </label>
                                            <input type="text" class="form-control" id="NamaUnitKerja" disabled
                                                value="{{ $user->instansi->kota->name }}">
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="NamaUnitKerja" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Unit Kerja/Instansi Daerah
                                        </label>
                                        <input type="text" class="form-control" id="NamaUnitKerja" disabled
                                            value="{{ $user->unitKerja->name }}">
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-12 mb-3">
                                    <label for="NamaUnitKerja" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Unit Kerja/Instansi Daerah
                                    </label>
                                    <select name="unit_kerja_id"
                                        class="form-control @error('unit_kerja_id') is-invalid @enderror">
                                        <option value="" selected> Pilih Unit Kerja/Instansi Daerah</option>
                                        @foreach ($unitKerjaList as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_kerja_id')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            @if (isset($user->nip))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="NIP" class="form-label">
                                            <span class="text-danger fw-bold">*</span> NIP
                                        </label>
                                        <input type="text" class="form-control" id="NIP" disabled
                                            value="{{ $user->nip }}">
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
                                    <label for="JenisKelamin" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Jenis Kelamin
                                    </label>
                                    <select name="jenis_kelamin"
                                        class="form-select mb-3 @error('jenis_kelamin') is-invalid @enderror"
                                        aria-label="JenisKelamin" id="JenisKelamin">
                                        <option value="" @if (!isset($user->userDetail->jenis_kelamin)) selected @endif>Pilih Jenis
                                            Kelamin</option>
                                        <option value="Pria" @if (isset($user->userDetail->jenis_kelamin) && $user->userDetail->jenis_kelamin === 'Pria') selected @endif>Pria
                                        </option>
                                        <option value="Wanita" @if (isset($user->userDetail->jenis_kelamin) && $user->userDetail->jenis_kelamin === 'Wanita') selected @endif>Wanita
                                        </option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('', '', $message) }}</strong>
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
                                    <input name="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" id="AlamatEmail"
                                        placeholder="Enter your email"
                                        @if (isset($user->userDetail->email)) value="{{ $user->userDetail->email }}" @endif>
                                    @error('email')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('', '', $message) }}</strong>
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
                                    <input name="no_hp" type="text"
                                        class="form-control @error('no_hp') is-invalid @enderror" id="NoHandphone"
                                        placeholder="Masukkan Nomor Handphone"
                                        @if (isset($user->userDetail->no_hp)) value="{{ $user->userDetail->no_hp }}" @endif>
                                    @error('no_hp')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('', '', $message) }}</strong>
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
        <!--end col-->
    </div>
    <!--end row-->
@endsection
