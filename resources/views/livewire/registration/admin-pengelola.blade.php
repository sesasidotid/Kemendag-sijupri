<div class="m-3">
    @if (Session::has('response') && Session::get('response')['title'] == 'Error')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong> NIP Telah terdaftar </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card card-body">
        <form wire:submit.prevent="store">
            <div class="row">
                <div class="mb-3">
                    <label class="form-label">
                        <i class="mdi mdi-card-account-details mr-2"></i>
                        Instansi
                    </label>
                    <input type="text" class="form-control" disabled value="{{ $instansi->name ?? '' }}">
                </div>
                @if ($unitKerja)
                    @if ($unitKerja->instansi->provinsi_id)
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="mdi mdi-card-account-details mr-2"></i>
                                Provinsi
                            </label>
                            <input type="text" class="form-control" disabled
                                value="{{ $unitKerja->instansi->provinsi->name ?? '' }}">
                        </div>
                    @endif
                    @if ($unitKerja->instansi->kabupaten_id)
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="mdi mdi-card-account-details mr-2"></i>
                                Kabupaten :
                            </label>
                            <input type="text" class="form-control" disabled
                                value="{{ $unitKerja->instansi->kabupaten->name }}">
                        </div>
                    @endif
                    @if ($unitKerja->instansi->kota_id)
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="mdi mdi-card-account-details mr-2"></i>
                                Kota :
                            </label>
                            <input type="text" class="form-control" disabled value="{{ $unitKerja->instansi->kota->name }}">
                        </div>
                    @endif
                @endif
                <hr>
                <div class="mb-3">
                    <label class="form-label">
                        <i class="mdi mdi-card-account-details mr-2"></i>
                        Pilih Unit Kerja/Instansi Daerah
                    </label>
                    <select wire:model="request.unit_kerja_id"
                        class="form-control @error('request.unit_kerja_id') is-invalid @enderror">
                        <option selected> Pilih Unit Kerja/Instansi Daerah</option>
                        @foreach ($unitKerjaList as $item)
                            {{-- @if ($item->wilayah_code) --}}
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            {{-- @endif --}}
                        @endforeach
                    </select>
                    @error('request.unit_kerja_id')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <div class="mb-3 has-validation">
                        <label class="form-label">Nama Lengkap</label>
                        <input wire:model="request.name" type="text"
                            class="form-control @error('request.name') is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('request.name')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input wire:model="request.nip" type="text"
                            class="form-control @error('request.nip') is-invalid @enderror" placeholder="NIP">
                        @error('request.nip')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="w-100">
                <button class="btn btn-secondary float-end" type="submit">
                    SIMPAN<i class="ms-1 uil-download-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>
