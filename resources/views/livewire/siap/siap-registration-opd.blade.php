<div class="m-3">
    <div class="card card-body">
        <div>
            <h3 class="mt-1 ml-2 mb-0">Form {{ $data['title'] }}</h3>
            <p class="mb-1 mt-1">
                *Form Pendaftaran Admin Unit Kerja {{ $data['title'] }}
            </p>
        </div>
    </div>
    <div class="card card-body">
        <form wire:submit.prevent="store">
            <div class="row">
                <div class="row">
                    {{-- <div class="mb-3">
                        <label class="form-label">
                            <i class="mdi mdi-card-account-details mr-2"></i>
                            Provinsi
                        </label>
                        <input type="text" class="form-control" disabled value="{{ $data['provinsi']->name ?? "" }}">
                    </div> --}}
                    {{-- @if ($data['kabupaten'])
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="mdi mdi-card-account-details mr-2"></i>
                                Kabupaten :
                            </label>
                            <input type="text" class="form-control" disabled value="{{ $data['kabupaten']->name }}">
                        </div>
                    @endif
                    @if ($data['kota'])
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="mdi mdi-card-account-details mr-2"></i>
                                Kota :
                            </label>
                            <input type="text" class="form-control" disabled value="{{ $data['kota']->name }}">
                        </div>
                    @endif --}}
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="mdi mdi-card-account-details mr-2"></i>
                            Pilih Unit Kerja
                        </label>
                        <select wire:model="request.unit_kerja_id"
                            class="form-control @error('request.unit_kerja_id') is-invalid @enderror">
                            <option selected> Plilih Unit Krja</option>
                            @foreach ($data['untiKerjaDinasList'] as $item)
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
                                class="form-control @error('request.name') is-invalid @enderror"
                                placeholder="Nama Lengkap">
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
            </div>
            <div class="w-100">
                <button class="btn btn-sm btn-primary float-end" type="submit">
                    SIMPAN<i class="ms-1 uil-download-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>
