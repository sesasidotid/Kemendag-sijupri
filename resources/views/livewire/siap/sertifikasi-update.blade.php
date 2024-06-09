<div class="col-md-12">
    <h4 class="text-center">Form Pengajuan Data Riwayat Sertifikasi</h4>
    <form wire:submit.prevent="store" id="collapseExample100">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="Kategori" class="form-label">
                        <span class="text-danger fw-bold">*</span> Kategori Sertifikasi
                    </label>
                    <select wire:model="request.kategori"
                        class="form-select mb-3 @error('request.kategori') is-invalid @enderror" aria-label="Kategori"
                        id="Kategori">
                        <option selected>Pilih Kategori Sertifikasi</option>
                        <option value="Pegawai Berhak">Pegawai Berhak</option>
                        <option value="Penyidik Pegawai Negri Sipil(PPNS)">Penyidik Pegawai Negri Sipil (PPNS)
                        </option>
                    </select>
                    @error('request.kategori')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="NoSK" class="form-label">
                        <span class="text-danger fw-bold">*</span> No. SK
                    </label>
                    <input wire:model="request.nomor_sk" type="text"
                        class="form-control @error('request.nomor_sk') is-invalid @enderror" id="NoSK"
                        placeholder="Masukkan No. SK ">
                    @error('request.nomor_sk')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalSK" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal SK
                    </label>
                    <input wire:model="request.tanggal_sk" type="date" data-provider="flatpickr"
                        class="form-control @error('request.tanggal_sk') is-invalid @enderror" id="TanggalSK"
                        placeholder="Masukkan Penugasan">
                    @error('request.tanggal_sk')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            @if (isset($request['kategori']) && $request['kategori'] != null && $request['kategori'] != 'Pegawai Berhak')
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="WilayahKerja" class="form-label">
                            <span class="text-danger fw-bold">*</span> Wilayah Kerja
                        </label>
                        <input wire:model="request.wilayah_kerja" type="text"
                            class="form-control @error('request.wilayah_kerja') is-invalid @enderror" id="WilayahKerja"
                            placeholder="Masukkan Penugasan">
                        @error('request.wilayah_kerja')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="TglMulai" class="form-label">
                            <span class="text-danger fw-bold">*</span> Tanggal Berlaku Mulai
                        </label>
                        <input wire:model="request.berlaku_mulai" type="date" data-provider="flatpickr"
                            class="form-control @error('request.berlaku_mulai') is-invalid @enderror" id="TglMulai"
                            placeholder="Masukkan Penugasan">
                        @error('request.berlaku_mulai')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="TglSampai" class="form-label">
                            <span class="text-danger fw-bold">*</span> Tanggal Berlaku Sampai
                        </label>
                        <input wire:model="request.berlaku_sampai" type="date" data-provider="flatpickr"
                            class="form-control @error('request.berlaku_sampai') is-invalid @enderror" id="TglSampai"
                            placeholder="Masukkan Penugasan">
                        @error('request.berlaku_sampai')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="UUKawalan" class="form-label">
                            <span class="text-danger fw-bold">*</span> UU yang di Kawal
                        </label>
                        <input wire:model="request.uu_kawalan" type="text"
                            class="form-control @error('request.uu_kawalan') is-invalid @enderror" id="UUKawalan"
                            placeholder="Masukkan Penugasan">
                        @error('request.uu_kawalan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="SKPengangkatan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Dokumen SK Pengangkatan
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_doc_sk" type="file" accept=".pdf"
                        class="form-control @error('request.file_doc_sk') is-invalid @enderror" id="SKPengangkatan"
                        placeholder="Masukkan Penugasan">
                    @error('request.file_doc_sk')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                    <div wire:loading wire:target="request.file_doc_sk">
                        <p class="mt-1">Uploading... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                        </p>
                    </div>
                </div>
            </div>
            @if (isset($request['kategori']) && $request['kategori'] != null && $request['kategori'] != 'Pegawai Berhak')
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="TKPPPNS" class="form-label">
                            <span class="text-danger fw-bold">*</span> Kartu Tanda Pengenal PPNS
                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                        </label>
                        <input wire:model="request.file_ktp_ppns" type="file" accept=".pdf"
                            class="form-control @error('request.file_ktp_ppns') is-invalid @enderror" id="TKPPPNS"
                            placeholder="Masukkan Penugasan">
                        @error('request.file_ktp_ppns')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                        <div wire:loading wire:target="request.file_ktp_ppns">
                            <p class="mt-1">Uploading... <i class="fa fa-spinner fa-spin"
                                    style="font-size:24px"></i></p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                    <button type="submit" class="btn btn-secondary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <table class="main-table table table-bordered nowrap align-middle" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori Sertifikasi</th>
                <th>No SK</th>
                <th>Tanggal SK</th>
                <th>Wilayah Kerja</th>
                <th>Tanggal Berlaku Mulai</th>
                <th>Tanggal Berlaku Sampai</th>
                <th>Dokument SK</th>
                <th>UU Kawalan</th>
                <th>Kartu Tanda Pengenal PPNS</th>
                <th>Status Verifikasi</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($sertifikasiList))
                @foreach ($sertifikasiList as $index => $sertifikasi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sertifikasi->kategori }}</td>
                        <td>{{ $sertifikasi->nomor_sk }}</td>
                        <td>{{ $sertifikasi->tanggal_sk }}</td>
                        <td>{{ $sertifikasi->wilayah_kerja ?? '' }}</td>
                        <td>{{ $sertifikasi->berlaku_mulai ?? '' }}</td>
                        <td>{{ $sertifikasi->berlaku_sampai ?? '' }}</td>
                        <td>{{ $sertifikasi->uu_kawalan }}</td>
                        <td class="text-center">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($sertifikasi->file_doc_sk) }}, 'Dokumen SK')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($sertifikasi->file_ktp_ppns) }}, 'KTP PPNS')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td>
                            {{ $sertifikasi->task_status ?? 'menunggu verifikasi' }}
                        </td>
                        <td scope="col" class="p-1 text-center">
                            {{ $sertifikasi->comment ?? '' }}
                        </td>
                        <td>
                            <a wire:click="delete({{ $sertifikasi->id }})" class="link-danger">
                                Hapus <i class=" las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <script>
        window.addEventListener('contentChanged', event => {
            initTable();
        });
        Livewire.on('fileUploading', () => {
            console.log('File uploading...');
        });
        Livewire.on('fileUploaded', () => {
            console.log('File uploaded!');
        });
    </script>
</div>
