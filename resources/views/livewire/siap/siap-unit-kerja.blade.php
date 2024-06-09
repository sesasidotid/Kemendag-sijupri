<div class="card card-body">
    @if (Session::get('status') === 1)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong> Data Berhasil Ditambahkan ! </strong>
            <button type="button" class="btn-close btn-primary" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form wire:submit.prevent="store">
        <div class="row">
            @if ($instansi)
                @if (!in_array($instansi->tipe_instansi_code, ['kementerian_lembaga', 'pusbin']))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">WIlayah</label>
                            <select wire:model="request.wilayah_code"
                                class="form-control @error('request.wilayah_code') is-invalid @enderror">
                                <option selected>Pilih WIlayah</option>
                                @foreach ($wilayahList as $item)
                                    <option value="{{ $item->code }}">{{ $item->region }}</option>
                                @endforeach
                            </select>
                            @error('request.wilayah_code')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @elseif ($provinsi)
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="mdi mdi-card-account-details mr-2"></i>
                            Provinsi
                        </label>
                        <input type="text" class="form-control" disabled value="{{ $provinsi->name }}">
                    </div>
                @endif
                @if ($kabupaten)
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="mdi mdi-card-account-details mr-2"></i>
                            Kabupaten :
                        </label>
                        <input type="text" class="form-control" disabled value="{{ $kabupaten->name }}">
                    </div>
                @endif
                @if ($kota)
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="mdi mdi-card-account-details mr-2"></i>
                            Kota :
                        </label>
                        <input type="text" class="form-control" disabled value="{{ $kota->name }}">
                    </div>
                @endif
                <div class="mb-3">
                    <label class="form-label">
                        <i class="mdi mdi-card-account-details mr-2"></i>
                        Nama Instansi
                    </label>
                    <input type="text" class="form-control" disabled value="{{ $instansi->name }}">
                </div>
            @endif
            <div class="col-md-12">
                <div class="mb-3 has-validation">
                    <label class="form-label">Nama Unit Kerja/Instansi Daerah</label>
                    <input wire:model="request.name" type="text"
                        class="form-control @error('request.name') is-invalid @enderror"
                        placeholder="Nama Unit Kerja/Instansi Daerah">
                    @error('request.name')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3 has-validation">
                    <label class="form-label">E-mail</label>
                    <input wire:model="request.email" type="email"
                        class="form-control @error('request.email') is-invalid @enderror" placeholder="email">
                    @error('request.email')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3 has-validation">
                    <label class="form-label">No HP</label>
                    <input wire:model="request.phone" type="text"
                        class="form-control @error('request.phone') is-invalid @enderror" placeholder="Nomor HP">
                    @error('request.phone')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Alamat Instansi</label>
                    <textarea wire:model="request.alamat" class="form-control @error('request.alamat') is-invalid @enderror" rows="4"
                        placeholder="exp : Jln. Adisucipt , no.8, Kupang"></textarea>
                    @error('request.alamat')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="w-100">
                <button class="btn btn-sm btn-primary float-end" type="submit">
                    SIMPAN<i class="ms-1 uil-download-alt"></i>
                </button>
            </div>
        </div>
    </form>


</div>
