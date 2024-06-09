<div>
    <form wire:submit.prevent="store">
        <div class="row">
            @if (isset($unitKerja->name))
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="NamaUnitKerja" class="form-label">
                            Kementerian/Lembaga
                        </label>
                        <input type="text" class="form-control" id="NamaUnitKerja" disabled
                            value="{{ $unitKerja->name }}">
                    </div>
                </div>
            @endif
            @if (isset($unitKerja->name))
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="NamaUnitKerja" class="form-label">
                            Unit Kerja
                        </label>
                        <input type="text" class="form-control" id="NamaUnitKerja" disabled
                            value="{{ $unitKerja->name }}">
                    </div>
                </div>
            @endif
            @if (isset($unitKerja->nip))
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="NIP" class="form-label">
                            NIP
                        </label>
                        <input type="text" class="form-control" id="NIP" disabled
                            value="{{ $unitKerja->nip }}">
                    </div>
                </div>
            @endif
            @if (isset($user->name))
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="Nama" class="form-label">
                            Nama
                        </label>
                        <input type="text" class="form-control" id="Nama" disabled value="{{ $user->name }}">
                    </div>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="JenisKelamin" class="form-label">
                        Jenis Kelamin
                    </label>
                    <select wire:model="request.jenis_kelamin" class="form-select mb-3" aria-label="JenisKelamin"
                        id="JenisKelamin">
                        <option selected>Pilih Jenis Kelamin</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                    @error('request.jenis_kelamin')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="AlamatEmail" class="form-label">
                        Alamat Email
                    </label>
                    <input wire:model="request.email" type="email"
                        class="form-control @error('request.email') is-invalid @enderror" id="AlamatEmail"
                        placeholder="Enter your email">
                    @error('request.email')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="NoHandphone" class="form-label">
                        Nomor Handphone
                    </label>
                    <input wire:model="request.no_hp" type="text"
                        class="form-control @error('request.no_hp') is-invalid @enderror" id="NoHandphone"
                        placeholder="Masukkan Nomor Handphone">
                    @error('request.no_hp')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--end col-->
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                    <button type="submit" class="btn btn-secondary">Simpan</button>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </form>
</div>
