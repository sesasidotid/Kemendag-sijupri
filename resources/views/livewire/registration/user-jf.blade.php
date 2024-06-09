<div class="m-3">
    <div class="card card-body">
        @if (Session::has('response') && Session::get('response')['title'] == 'Error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> NIP Telah terdaftar </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form wire:submit.prevent="store">
            <div class="row">
                @if ($provinsiData)
                    <div class="col-md-12">
                        <div class="mb-3">
                            <span class="text-danger fw-bold">*</span>
                            <label class="form-label">Provinsi</label>
                            <input type="text" class="form-control" value="{{ $provinsiData->name }}" disabled>
                            </select>
                        </div>
                    </div>
                @endif
                @if ($kabupatenData)
                    <div class="col-md-12">
                        <div class="mb-3">
                            <span class="text-danger fw-bold">*</span>
                            <label class="form-label">Kabupaten</label>
                            <input type="text" class="form-control" value="{{ $kabupatenData->name }}" disabled>
                            </select>
                        </div>
                    </div>
                @endif
                @if ($kotaData)
                    <div class="col-md-12">
                        <div class="mb-3">
                            <span class="text-danger fw-bold">*</span> <label class="form-label">Kota</label>
                            <input type="text" class="form-control" value="{{ $kotaData->name }}" required disabled>
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="mb-3">
                        <span class="text-danger fw-bold">*</span>
                        <label class="form-label">Unit Kerja/Instansi Daerah</label>
                        <input type="text" class="form-control" value="{{ $unitKerjaData->name }}" required disabled>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <span class="text-danger fw-bold">*</span>
                        <label class="form-label">Email Unit Kerja/Instansi Daerah</label>
                        <input type="text" class="form-control" value="{{ $unitKerjaData->email }}"
                            placeholder="Email Unit Kerja/Instansi Daerah" disabled>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <span class="text-danger fw-bold">*</span>
                        <label class="form-label">Alamat Unit Kerja/Instansi Daerah</label>
                        <input type="text" class="form-control" value="{{ $unitKerjaData->alamat }}"
                            placeholder="Alamat Unit Kerja/Instansi Daerah" disabled>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <div class="mb-3 has-validation">
                        <span class="text-danger fw-bold">*</span>
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
                        <span class="text-danger fw-bold">*</span>
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
                <button class="btn btn-sm btn-primary float-end" type="submit">
                    SIMPAN<i class="ms-1 uil-download-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>
