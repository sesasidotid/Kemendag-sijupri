<div>
    <h4 class="text-center">Form Pangkat</h4>
    <form wire:submit.prevent="store" id="pangkat">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TMT" class="form-label">
                        Terhitung Mulai Tanggal
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
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="Pangkat" class="form-label">
                        Pangkat
                    </label>
                    <select wire:model="request.pangkat_id"
                        class="form-select mb-3 @error('request.pangkat_id') is-invalid @enderror" aria-label="Pangkat"
                        id="Pangkat">
                        <option selected>Pilih Pangkat/Golongan Ruang</option>
                        @if (isset($pangkatList))
                            @foreach ($pangkatList as $item)
                                <option value="{{ $item->id }}">{{ $item->description }}/{{ $item->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('request.pangkat_id')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileSKPangkat" class="form-label">
                        File SK Pangkat
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_sk_pangkat" type="file" accept=".pdf"
                        class="form-control @error('request.file_sk_pangkat') is-invalid @enderror"
                        id="FileSKPangkat" />
                    @error('request.file_sk_pangkat')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                    <div wire:loading wire:target="request.file_sk_pangkat">
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
    <table class="main-table table table-bordered nowrap align-middle w-100">
        <thead>
            <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">pangkat</th>
                <th scope="col">SK Pangkat</th>
                <th scope="col">Status</th>
                <th scope="col">Comment </th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($userPangkatList))
                @foreach ($userPangkatList as $index => $pangkat)
                    <tr>
                        <td scope="col">{{ $index + 1 }}</td>
                        <td scope="col">{{ $pangkat->pangkat->description }}/{{ $pangkat->pangkat->name }}</td>
                        <td class="text-center" scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($pangkat->file_sk_pangkat) }}, 'SK Pangkat')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col" class="p-1 text-center">
                            {{ $pankat->task_status ?? 'PENDING' }}
                        </td>
                        <td scope="col" class="p-1 text-center">
                            {{ $pangkat->comment ?? '' }}
                        </td>
                        <td scope="col" class="p-1 text-center">
                            @if (($pankat->task_status ?? 'PENDING') === 'APPROVE')
                                <a disabled wire:click="delete({{ $pangkat->id }})" class="link-danger">
                                    Hapus <i class=" las la-trash"></i>
                                </a>
                            @else
                                <a wire:click="delete({{ $pangkat->id }})" class="link-danger">
                                    Hapus <i class=" las la-trash"></i>
                                </a>
                            @endif
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
