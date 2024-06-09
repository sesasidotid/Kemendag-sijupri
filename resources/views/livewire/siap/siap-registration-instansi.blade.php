<div class="card">
    <div class="card-header bg-light border-0">
        <h5 class="card-title mb-md-0 flex-grow-1">
            Form Admin Instansi
        </h5>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="store">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Admin Tipe <span class="text-danger">*</span></label>
                        <select wire:model="request.tipe_instansi_code"
                            class="form-control @error('request.tipe_instansi_code') is-invalid @enderror">
                            <option selected>Pilih Tipe Admin </option>
                            <option value="kementerian_lembaga">Kementerian/Lembaga</option>
                            <option value="provinsi">Provinsi</option>
                            <option value="kabupaten">Kabupaten</option>
                            <option value="kota">Kota</option>
                        </select>
                        @error('request.tipe_instansi_code')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @if ($request['tipe_instansi_code'] == 'kementerian_lembaga')
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Pilih Kementerian/Lembaga</label>
                            <select wire:model="request.unit_kerja_id"
                                class="form-control @error('request.unit_kerja_id') is-invalid @enderror">
                                <option selected>Pilih Kementerian/Lembaga</option>
                                @foreach ($data['untiKerjaKlList'] as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('request.unit_kerja_id')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Pilih Dinas Kepegawaian</label>
                            <select wire:model="request.unit_kerja_nama"
                                class="form-control @error('request.unit_kerja_nama') is-invalid @enderror">
                                <option selected>Pilih Dinas</option>
                                <option value="BKPSDMP">
                                    Badan Kepegawaian Dan Pengembangan Sumber Daya Manusia
                                </option>
                                <option value="BKD">Badan Kepegawaian Daerah</option>
                            </select>
                            @error('request.unit_kerja_nama')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Pilih Provinsi</label>
                            <select wire:model="request.provinsi_id"
                                class="form-control @error('request.provinsi_id') is-invalid @enderror">
                                <option selected>Pilih Provinsi</option>
                                @foreach ($data['provinsiList'] as $item)
                                    <option value="{{ $item->id }}">{{ ucfirst($item->name) }}</option>
                                @endforeach
                            </select>
                            @error('request.provinsi_id')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if ($request['tipe_instansi_code'] == 'kabupaten')
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Pilih Kabupaten</label>
                                <select wire:model="request.kabupaten_id"
                                    class="form-control @error('request.kabupaten_id') is-invalid @enderror">
                                    <option selected>Pilih Kabupaten</option>
                                    @foreach ($data['kabupatenList'] as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('request.kabupaten_id')
                                    <span class="invalid-feedback">
                                        <strong>{{ str_replace('request.', '', $message) }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    @if ($request['tipe_instansi_code'] == 'kota')
                        <div class="col-md-12" id="kotaSection">
                            <div class="mb-3">
                                <label class="form-label">Pilih Kota</label>
                                <select wire:model="request.kota_id"
                                    class="form-control @error('request.kota_id') is-invalid @enderror">
                                    <option selected>Pilih Kota</option>
                                    @foreach ($data['kotaList'] as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('request.kota_id')
                                    <span class="invalid-feedback">
                                        <strong>{{ str_replace('request.', '', $message) }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif
                @endif
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
