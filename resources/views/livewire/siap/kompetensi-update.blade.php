<div class="col-md-12">
    <h4 class="text-center">Form Pengajuan Data Riwayat Kompetensi</h4>
    <form wire:submit.prevent="store" id="collapseExample100">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="NamaKompetensi" class="form-label">
                        <span class="text-danger fw-bold">*</span> Nama Kompetensi
                    </label>
                    <input wire:model="request.name"
                        class="form-control @error('request.kategori') is-invalid @enderror"
                        placeholder="Nama Kompetensi">
                    @error('request.name')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="KategoriKompetensi" class="form-label">
                        <span class="text-danger fw-bold">*</span> Kategori Pengembangan
                    </label>
                    <select wire:model="request.kategori"
                        class="form-select mb-3 @error('request.kategori') is-invalid @enderror"
                        aria-label="KategoriKompetensi" id="KategoriKompetensi">
                        <option value="" selected>Pilih Kategori Pengembangan</option>
                        <option value="Pelatihan Fungsional">Pelatihan Fungsional</option>
                        <option value="Pelatihan Teknis">Pelatihan Teknis</option>
                        <option value="Coaching/Mentoring">Coaching/Mentoring</option>
                        <option value="Penugasan">Penugasan</option>
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
                    <label for="TanggalMulai" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Mulai
                    </label>
                    <input wire:model="request.tgl_mulai" type="date" data-provider="flatpickr"
                        class="form-control @error('request.tgl_mulai') is-invalid @enderror" id="TanggalMulai"
                        placeholder="Masukkan Tanggal Mulai">
                    @error('request.tgl_mulai')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalSelesai" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Selesai
                    </label>
                    <input wire:model="request.tgl_selesai" type="date" data-provider="flatpickr"
                        class="form-control @error('request.tgl_selesai') is-invalid @enderror" id="TanggalSelesai"
                        placeholder="Masukkan Tanggal Selesai">
                    @error('request.tgl_selesai')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="TanggalSertifikat" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Sertifikat
                    </label>
                    <input wire:model="request.tgl_sertifikat" type="date" data-provider="flatpickr"
                        class="form-control @error('request.tgl_sertifikat') is-invalid @enderror"
                        id="TanggalSertifikat" placeholder="Masukkan Tanggal Sertifikat">
                    @error('request.tgl_sertifikat')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileSertifikat" class="form-label">
                        <span class="text-danger fw-bold">*</span> File Serifikat
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_sertifikat" type="file" accept=".pdf"
                        class="form-control @error('request.file_sertifikat') is-invalid @enderror"
                        id="FileSertifikat" />
                    @error('request.file_sertifikat')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                    <div wire:loading wire:target="request.file_sertifikat">
                        <p class="mt-1">Uploading... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                    <button type="submit" class="btn btn-secondary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kompetensi</th>
                <th>Kategori Pengembangan</th>
                <th>File Sertifikat</th>
                <th>Status</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($kompetensiList))
                @foreach ($kompetensiList as $index => $kompetensi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kompetensi->name }}</td>
                        <td>{{ $kompetensi->kategori }}</td>
                        <td>
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($kompetensi->file_sertifikat) }}, 'Sertifikat')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td>{{ $kompetensi->task_status }}</td>
                        <td>{{ $kompetensi->comment ?? '' }}</td>
                        <td>
                            <a wire:click="delete({{ $kompetensi->id }})" class="link-danger">
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
