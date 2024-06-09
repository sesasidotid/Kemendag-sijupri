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
                    User Detail
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('/profile/detail') }}">
                        @csrf
                        <div class="row">
                            @if (isset($user->unitKerja->name))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="NamaUnitKerja" class="form-label">
                                            Instansi
                                        </label>
                                        <input type="text" class="form-control" id="NamaUnitKerja" disabled
                                            value="{{ $user->instansi->name }}">
                                    </div>
                                </div>
                            @endif
                            @if (isset($user->unitKerja->name))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="NamaUnitKerja" class="form-label">
                                            Unit Kerja
                                        </label>
                                        <input type="text" class="form-control" id="NamaUnitKerja" disabled
                                            value="{{ $user->unitKerja->name }}">
                                    </div>
                                </div>
                            @endif
                            @if (isset($user->unitKerja->nip))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="NIP" class="form-label">
                                            NIP
                                        </label>
                                        <input type="text" class="form-control" id="NIP" disabled
                                            value="{{ $user->unitKerja->nip }}">
                                    </div>
                                </div>
                            @endif
                            @if (isset($user->name))
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Nama" class="form-label">
                                            Nama
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
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="AlamatEmail" class="form-label">
                                        Alamat Email
                                    </label>
                                    <input name="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" id="AlamatEmail"
                                        placeholder="Enter your email">
                                    @error('email')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="NoHandphone" class="form-label">
                                        Nomor Handphone
                                    </label>
                                    <input name="no_hp" type="text"
                                        class="form-control @error('no_hp') is-invalid @enderror" id="NoHandphone"
                                        placeholder="Masukkan Nomor Handphone">
                                    @error('no_hp')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('tables')
    <script>
        new DataTable('#user-pak', {
            "scrollX": true
        });
        new DataTable('#user-jabatan', {
            "scrollX": true
        });
        new DataTable('#user-pangkat', {
            "scrollX": true
        });
        new DataTable('#user-pendidikan', {
            "scrollX": true
        });
    </script>
@endsection
