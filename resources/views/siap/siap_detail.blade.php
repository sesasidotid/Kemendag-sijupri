<div>
    <form method="POST" action="{{ route('/siap/user_detail/store') }}" enctype="multipart/form-data">
        @csrf
        @if (($userDetail->task_status ?? '') == 'REJECT')
            <div class="card card-body">
                <h5 class="text-danger">User Detail Ditolak</h5>
                @if (isset($userDetail->comment) && $userDetail->comment && $userDetail->comment != '')
                    <div class="w-100 ms-3">
                        <i class="fw-bold">Komen :</i> {{ $userDetail->comment }}
                    </div>
                @endif
            </div>
        @endif
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
                        <input type="text" class="form-control" id="Nama" disabled value="{{ $user->name }}">
                    </div>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="NIK" class="form-label">
                        <span class="text-danger fw-bold">*</span> NIK
                    </label>
                    <input name="nik" type="text" class="form-control" id="NIK" placeholder="Masukkan NIK"
                        value="{{ $userDetail->nik ?? '' }}">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="JenisKelamin" class="form-label">
                        <span class="text-danger fw-bold">*</span> Jenis Kelamin
                    </label>
                    <select name="jenis_kelamin" class="form-select mb-3" aria-label="JenisKelamin" id="JenisKelamin">
                        <option @if (($userDetail->jenis_kelamin ?? ('' ?? null)) == null) selected @endif>
                            Pilih Jenis
                            Kelamin</option>
                        <option @if (($userDetail->jenis_kelamin ?? '') == 'Pria') selected @endif value="Pria">
                            Pria
                        </option>
                        <option @if (($userDetail->jenis_kelamin ?? '') == 'Wanita') selected @endif value="Wanita">Wanita</option>
                    </select>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="AlamatEmail" class="form-label">
                        <span class="text-danger fw-bold">*</span> Alamat Email <span class="text-info">(sesuai dengan email yang terdaftar pada KUDAGANG)</span>
                    </label>
                    <input name="email" type="email" class="form-control" id="AlamatEmail"
                        placeholder="Enter your email" value="{{ $userDetail->email ?? '' }}">
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="NoHandphone" class="form-label">
                        <span class="text-danger fw-bold">*</span> Nomor Handphone
                    </label>
                    <input name="no_hp" type="text" class="form-control" id="NoHandphone"
                        placeholder="Masukkan Nomor Handphone" value="{{ $userDetail->no_hp ?? '' }}">
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TempatLahir" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tempat Lahir
                    </label>
                    <input name="tempat_lahir" type="text" class="form-control" id="TempatLahir"
                        placeholder="Masukkan Tempat Lahir" value="{{ $userDetail->tempat_lahir ?? '' }}" />
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalLahir" class="form-label">
                        <span class="text-danger fw-bold">*</span>Tanggal Lahir
                    </label>
                    <input name="tanggal_lahir" type="date" data-provider="flatpickr" class="form-control"
                        id="TanggalLahir"
                        value="{{ isset($userDetail->tanggal_lahir) ? date('Y-m-d', strtotime($userDetail->tanggal_lahir)) : '' }}" />
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileKTP" class="form-label">
                        <span class="text-danger fw-bold">*</span> File KTP
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    @if (isset($userDetail->file_ktp) && $userDetail->file_ktp)
                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_ktp" href="javascript:void(0);"
                            onclick="previewModal({{ json_encode($userDetail->file_ktp) }}, 'Ijazah')">
                            Lihat
                        </a>
                    @endif
                    <input name="file_ktp" type="file" accept=".pdf" class="form-control" id="FileKTP" />
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end mb-2">
                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
