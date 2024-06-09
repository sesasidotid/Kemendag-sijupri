<div class="col-md-12">
    <div class="d-flex justify-content-end bg-light ">
        <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">

            <li class="list-inline-item">
                <span class="badge bg-primary-subtle text-primary">
                    <a class="align-middle minimize-card text-primary" data-bs-toggle="collapse" href="#collapseExample100"
                        role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <i class="mdi mdi-plus align-middle plus"><span
                                style="font-style: normal ; font-size: 14px">Maximize Form</span></i>
                        <i class="mdi mdi-minus align-middle minus"><span
                                style="font-style: normal ; font-size: 14px">Minimize Form</span></i>
                    </a>
                </span>
            </li>

        </ul>
    </div>
    <div class="card-header bg-light">
        <h4 class="text-center">Form Pengajuan Data Riwayat Sertifikasi</h4>
    </div>

    <div class="card-body d-flex justify-content-center">
        <form wire:submit.prevent="store" id="collapseExample100">

            <div class="row">

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="Pendidikan" class="form-label">
                            <span class="text-danger fw-bold">*</span> Kategori Sertifikasi
                        </label>
                        <select wire:model="request.level"
                            class="form-select mb-3 @error('request.level') is-invalid @enderror"
                            aria-label="Pendidikan" id="Pendidikan">
                            <option disabled selected>Pilih Kategori Sertifikasi</option>
                            <option value="">Pegawai Berhak</option>
                            <option value="">Penyidik Pegawai Negri Sipil </option>

                        </select>
                        @error('request.level')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!--end col-->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="InstansiPendidikan" class="form-label">
                            <span class="text-danger fw-bold">*</span> No. SK
                        </label>
                        <input wire:model="request.instansi_pendidikan" type="text"
                            class="form-control @error('request.instansi_pendidikan') is-invalid @enderror"
                            id="InstansiPendidikan" placeholder="Masukkan No. SK ">
                        @error('request.instansi_pendidikan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!--end col-->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="Jurusan" class="form-label">
                            <span class="text-danger fw-bold">*</span> Tanggal SK
                        </label>
                        <input wire:model="request.jurusan" type="date" data-provider="flatpickr"
                            class="form-control @error('request.jurusan') is-invalid @enderror" id="Jurusan"
                            placeholder="Masukkan Penugasan">
                        @error('request.jurusan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="Jurusan" class="form-label">
                            <span class="text-danger fw-bold">*</span> UU yang di Kawal
                        </label>
                        <input wire:model="request.jurusan" type="text"
                            class="form-control @error('request.jurusan') is-invalid @enderror" id="Jurusan"
                            placeholder="Masukkan Penugasan">
                        @error('request.jurusan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="Jurusan" class="form-label">
                            <span class="text-danger fw-bold">*</span> Wilayah Kerja
                        </label>
                        <input wire:model="request.jurusan" type="text"
                            class="form-control @error('request.jurusan') is-invalid @enderror" id="Jurusan"
                            placeholder="Masukkan Penugasan">
                        @error('request.jurusan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="Jurusan" class="form-label">
                            <span class="text-danger fw-bold">*</span> Tanggal Berlaku Mulai
                        </label>
                        <input wire:model="request.jurusan" type="date" data-provider="flatpickr"
                            class="form-control @error('request.jurusan') is-invalid @enderror" id="Jurusan"
                            placeholder="Masukkan Penugasan">
                        @error('request.jurusan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="Jurusan" class="form-label">
                            <span class="text-danger fw-bold">*</span> Tanggal Berlaku Sampai
                        </label>
                        <input wire:model="request.jurusan" type="date" data-provider="flatpickr"
                            class="form-control @error('request.jurusan') is-invalid @enderror" id="Jurusan"
                            placeholder="Masukkan Penugasan">
                        @error('request.jurusan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="Jurusan" class="form-label">
                            <span class="text-danger fw-bold">*</span> Dokumen SK Pengangkatan
                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                        </label>
                        <input wire:model="request.jurusan" type="file" accept=".pdf"
                            class="form-control @error('request.jurusan') is-invalid @enderror" id="Jurusan"
                            placeholder="Masukkan Penugasan">
                        @error('request.jurusan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="Jurusan" class="form-label">
                            <span class="text-danger fw-bold">*</span> Kartu Tanda Pengenal PPNS
                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                        </label>
                        <input wire:model="request.jurusan" type="file" accept=".pdf"
                            class="form-control @error('request.jurusan') is-invalid @enderror" id="Jurusan"
                            placeholder="Masukkan Penugasan">
                        @error('request.jurusan')
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
    <!-- Striped Rows -->
    <div class="col-lg-12  mt-1">
        <div class="d-flex justify-content-end bg-light ">
            <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">

                <li class="list-inline-item">
                    <span class="badge bg-primary-subtle text-primary">
                        <a class="align-middle minimize-card text-primary" data-bs-toggle="collapse" href="#tablex"
                            role="button" aria-expanded="false" aria-controls="collapseExample2">
                            <i class="mdi mdi-plus align-middle plus"><span
                                    style="font-style: normal ; font-size: 14px">Maximize Form</span></i>
                            <i class="mdi mdi-minus align-middle minus"><span
                                    style="font-style: normal ; font-size: 14px">Minimize Form</span></i>
                        </a>
                    </span>
                </li>

            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center mb-0">Data Riwayat Kompetensi</h4>
            </div>
            <div class="card-body" id="tablex">
                <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
                    <thead class="bg-light  ">
                        <tr>
                            <th>No</th>
                            <th>Kategori Sertifikasi</th>
                            <th>No SK</th>
                            <th>Tanggal SK</th>
                            <th>UU </th>
                            <th>Dokument SK</th>
                            <th>Kartu Tanda Pengenal PPNS</th>
                            <th>Status Verifikasi</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($pendidikanList))
                            @foreach ($pendidikanList as $index => $pendidikan)
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Sertifikasi</th>
                                    <th>No SK</th>
                                    <th>Tanggal SK</th>
                                    <th>UU </th>
                                    <th>Dokument SK</th>
                                    <th>Kartu Tanda Pengenal PPNS</th>
                                    <td><span class="badge bg-secondary-subtle text-secondary">Re-open</span></td>
                                    <td class="text-center">
                                        <a class="link-info" href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($pendidikan->file_ijazah) }}, 'SK Jabatan')">

                                            <span class="badge bg-danger-subtle text-secondary">Lihat <i
                                                    class="mdi mdi-eye"></i></span>
                                        </a>
                                        <a class="link-danger" href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($pendidikan->file_ijazah) }}, 'SK Jabatan')">

                                            <span class="badge bg-danger-subtle text-danger">Hapus <i
                                                    class=" las la-trash"></i></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
