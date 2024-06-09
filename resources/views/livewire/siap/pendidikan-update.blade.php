<div class="col-md-12">
    <h4 class="text-center">Form Pengajuan Data Riwayat Pendidikan</h4>
    <form wire:submit.prevent="store" id="collapseExample100">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="Pendidikan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tingkat Pendidikan
                    </label>
                    <select wire:model="request.level"
                        class="form-select mb-3 @error('request.level') is-invalid @enderror" aria-label="Pendidikan"
                        id="Pendidikan">
                        <option selected>Pilih Tingkat Pendidikan</option>
                        <option value="SMA">SLTA/SMK</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1/D4</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                    @error('request.level')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="InstansiPendidikan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Nama Institusi Pendidikan
                    </label>
                    <input wire:model="request.instansi_pendidikan" type="text"
                        class="form-control @error('request.instansi_pendidikan') is-invalid @enderror"
                        id="InstansiPendidikan" placeholder="Masukkan Nama Institusi Pendidikan ">
                    @error('request.instansi_pendidikan')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="Jurusan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Jurusan/Program Studi
                    </label>
                    <input wire:model="request.jurusan" type="text"
                        class="form-control @error('request.jurusan') is-invalid @enderror" id="Jurusan"
                        placeholder="Masukkan Jurusan/Program Studi">
                    @error('request.jurusan')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="InstansiPendidikan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tingkat Pendidikan Tanggal Ijazah
                    </label>
                    <input wire:model="request.bulan_kelulusan" type="date" data-provider="flatpickr"
                        class="form-control @error('request.bulan_kelulusan') is-invalid @enderror"
                        id="InstansiPendidikan" placeholder="Masukkan Instansi Pendidikan">
                    @error('request.bulan_kelulusan')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileIjazah" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tingkat Pendidikan File Ijazah
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_ijazah" type="file" accept=".pdf"
                        class="form-control  border-bottom-1 @error('request.file_ijazah') is-invalid @enderror"
                        id="FileIjazah" />
                    @error('request.file_ijazah')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                    <div wire:loading wire:target="request.file_ijazah">
                        <p class="mt-1">Uploading... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                        </p>
                    </div>
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
    <hr>
    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pendidikan</th>
                <th>Instansi</th>
                <th>Jurusan</th>
                <th>File Ijazah</th>
                <th>Tanggal Ijazah</th>
                <th>Status</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="">
            @if (isset($pendidikanList))
                @foreach ($pendidikanList as $index => $pendidikan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pendidikan->level }}</td>
                        <td>{{ $pendidikan->instansi_pendidikan }}</td>
                        <td>{{ $pendidikan->jurusan }}</td>
                        <td class="text-center">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($pendidikan->file_ijazah) }}, 'Ijazah')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td>{{ $pendidikan->tgl_ijasah }} 1</td>
                        <td>
                            {{ $pankat->task_status ?? 'menunggu verifikasi' }}
                        </td>
                        <td scope="col" class="p-1 text-center">
                            {{ $pangkat->comment ?? '' }}
                        </td>
                        <td class="text-center">
                            <a wire:click="delete({{ $pendidikan->id }})" class="link-danger">
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
