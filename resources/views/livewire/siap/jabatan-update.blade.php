<div class="col-md-12">
    <h4 class="text-center">Form Pengajuan Data Riwayat Jabatan</h4>
    <form wire:submit.prevent="store" id="collapseExample102">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="Jabatan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Jabatan
                    </label>


                    <select wire:model="request.jabatan_code" id="Jabatan"
                        class="form-select  @error('request.jabatan_code') is-invalid @enderror" name="state">
                        @if (isset($jabatanList))
                            <div
                                style="position: absolute ;  display: none;
                        position: absolute;">
                                <option selected>Pilih Jabatan Fungsional Perdagangan</option>
                                @foreach ($jabatanList as $item)
                                    <option value="{{ $item->code }}">- {{ $item->name }}</option>
                                @endforeach
                            </div>
                        @endif
                    </select>
                    @error('request.jabatan_code')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="Jenjang" class="form-label">
                        <span class="text-danger fw-bold">*</span> Jenjang
                    </label>
                    <select wire:model="request.jenjang_code"
                        class=" form-select  @error('request.jenjang_code') is-invalid @enderror" id="Jenjang">
                        <option selected>Pilih Jenjang</option>
                        @if (isset($jenjangList))
                            @foreach ($jenjangList as $item)
                                <option value="{{ $item->code }}">- {{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('request.jenjang_code')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="TMT" class="form-label">
                        <span class="text-danger fw-bold">*</span> Terhitung Mulai Tanggal
                    </label>
                    <input wire:model="request.tmt" type="date" data-provider="flatpickr"
                        class="form-control @error('request.tmt') is-invalid @enderror" id="TMT"
                        placeholder="Masukkan TMT">
                    @error('request.tmt')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileSKJabatan" class="form-label">
                        <span class="text-danger fw-bold">*</span> File SK Jabatan
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_sk_jabatan" type="file" accept=".pdf"
                        class="form-control @error('request.file_sk_jabatan') is-invalid @enderror"
                        id="FileSKJabatan" />
                    @error('request.file_sk_jabatan')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                    <div wire:loading wire:target="request.file_sk_jabatan">
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
    <table class="main-table table table-bordered nowrap align-middle w-100">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">TMT</th>
                <th scope="col">Tipe Jabatan</th>
                <th scope="col">Jenjang</th>
                <th scope="col">Nama Jabatan</th>
                <th scope="col">SK Jabatan</th>
                <th scope="col">Tanggal Pengajuan</th>
                <th scope="col">Status</th>
                <th scope="col">Comment</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($userJabatanList))
                @foreach ($userJabatanList as $index => $jabatan)
                    <tr>
                        <td scope="col">{{ $index + 1 }}</td>
                        <td scope="col">{{ $jabatan->tmt }}</td>
                        <td scope="col">{{ $jabatan->tipe_jabatan }}</td>
                        <td scope="col">{{ $jabatan->jenjang->name ?? '' }}</td>
                        <td scope="col">{{ $jabatan->name }}</td>
                        <td scope="col" class="text-center">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($jabatan->file_sk_jabatan) }}, 'SK Jabatan')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col" class="p-1">
                            {{ $jabatan->created_at }}
                        </td>
                        <td scope="col">{{ $jabatan->task_status ?? 'menunggu verifikasi' }}</td>
                        <td scope="col">--</td>
                        <td scope="col">
                            <a wire:click="delete({{ $jabatan->id }})" class="link-danger">
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
