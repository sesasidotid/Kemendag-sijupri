<div class="m-3">
    <div class="card card-body">
        <div>
            <h3 class="mt-1 ml-2 mb-0">Form {{ $data['title'] }}</h3>
        </div>
    </div>
    <div class="card card-body">
        <form wire:submit.prevent="store">
            <div class="row">
                @if ($data['provinsi'])
                    <div class="col-md-12">
                        <div class="mb-3">
                            <span class="text-danger fw-bold">*</span>      <label class="form-label">Provinsi</label>
                            <input type="text" class="form-control" value="{{ $data['provinsi']->name }}" disabled>
                            </select>
                        </div>
                    </div>
                @endif
                @if ($data['kabupaten'])
                    <div class="col-md-12">
                        <div class="mb-3">
                            <span class="text-danger fw-bold">*</span>     <label class="form-label">Kabupaten</label>
                            <input type="text" class="form-control" value="{{ $data['kabupaten']->name }}" disabled>
                            </select>
                        </div>
                    </div>
                @endif
                @if ($data['kota'])
                    <div class="col-md-12">
                        <div class="mb-3">
                            <span class="text-danger fw-bold">*</span>  <label class="form-label">Kota</label>
                            <input type="text" class="form-control" value="{{ $data['kota']->name }}" required
                                disabled>
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="mb-3">
                        <span class="text-danger fw-bold">*</span>   <label class="form-label">Unit Kerja/Instansi Daerah</label>
                        <input type="text" class="form-control" value="{{ $data['unitKerja']->name }}" required
                            disabled>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <span class="text-danger fw-bold">*</span>   <label class="form-label">Email Unit Kerja/Instansi Daerah</label>
                        <input type="text" class="form-control" value="{{ $data['unitKerja']->email }}"
                            placeholder="NIP" disabled>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <span class="text-danger fw-bold">*</span>    <label class="form-label">Alamat Unit Kerja/Instansi Daerah</label>
                        <input type="text" class="form-control" value="{{ $data['unitKerja']->alamat }}"
                            placeholder="NIP" disabled>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3 has-validation">
                        <span class="text-danger fw-bold">*</span>    <label class="form-label">Nama Lengkap</label>
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
                        <span class="text-danger fw-bold">*</span>   <label class="form-label">NIP</label>
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
