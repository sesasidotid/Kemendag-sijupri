<div class="card">
    <div class="card-body">
        @if (Session::has('response') && Session::get('response')['title'] == 'Error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> NIP Telah terdaftar </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form wire:submit.prevent="store">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <a href="" class=""> </a>
                        <label class="form-label text-body-secondary"><i class="las la-user-circle text-primary"></i>
                            Tipe Admin <span class="text-danger">*</span></label>
                        <select wire:model="request.tipe_instansi_code"
                            class="form-select @error('request.tipe_instansi_code') is-invalid @enderror">
                            <option selected>Pilih Tipe Admin </option>
                            <option value="pusbin">Sekretariat Ditjen/Badan/Setjen</option>
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
                            <label class="form-label text-body-secondary"><i class=" las la-building text-primary"></i>
                                Pilih Kementerian/Lembaga <span class="text-danger">*</span> </label>
                            <select wire:model="request.instansi_id"
                                class="form-control @error('request.instansi_id') is-invalid @enderror">
                                <option selected>Pilih Kementerian/Lembaga</option>
                                @foreach ($instansiList as $instansi)
                                    <option value="{{ $instansi->id }}">{{ ucfirst($instansi->name) }}</option>
                                @endforeach
                            </select>
                            @error('request.instansi_id')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @elseif ($request['tipe_instansi_code'] == 'pusbin')
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary"><i class=" las la-building text-primary"></i>
                                Pilih Sekretariat Ditjen/Badan/Setjen <span class="text-danger">*</span> </label>
                            <select wire:model="request.instansi_id"
                                class="form-control @error('request.instansi_id') is-invalid @enderror">
                                <option selected>Pilih Sekretariat Ditjen/Badan/Setjen</option>
                                @foreach ($instansiList as $instansi)
                                    <option value="{{ $instansi->id }}">{{ ucfirst($instansi->name) }}</option>
                                @endforeach
                            </select>
                            @error('request.instansi_id')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @elseif($request['tipe_instansi_code'] == 'provinsi')
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary"><i class=" las la-building text-primary"></i>
                                Pengelola Kepegawaian <span class="text-danger">*</span></label>
                            <select wire:model="request.instansi_initials"
                                class="form-select @error('request.instansi_initials') is-invalid @enderror">
                                <option selected>Pilih Pengelola</option>
                                <option value="1">
                                    Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Provinsi
                                </option>
                                <option value="2">Badan Kepegawaian Daerah Provinsi</option>
                            </select>
                            @error('request.instansi_initials')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary"><i
                                    class=" las la-search-location text-primary"></i> Pilih Provinsi <span
                                    class="text-danger">*</span></label>
                            <select wire:model="request.provinsi_id"
                                class="form-select @error('request.provinsi_id') is-invalid @enderror">
                                <option selected>Pilih Provinsi</option>
                                @foreach ($provinsiList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('request.provinsi_id')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endif
                @if ($request['tipe_instansi_code'] == 'kabupaten')
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary"><i class=" las la-building text-primary"></i>
                                Pengelola Kepegawaian <span class="text-danger">*</span></label>
                            <select wire:model="request.instansi_initials"
                                class="form-select @error('request.instansi_initials') is-invalid @enderror">
                                <option selected>Pilih Pengelola</option>
                                <option value="1">
                                    Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kabupaten
                                </option>
                                <option value="2">Badan Kepegawaian Daerah Kabupaten</option>
                            </select>
                            @error('request.instansi_initials')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary"><i
                                    class=" las la-search-location text-primary"></i> Pilih Provinsi <span
                                    class="text-danger">*</span></label>
                            <select wire:model="request.provinsi_id"
                                class="form-select @error('request.provinsi_id') is-invalid @enderror">
                                <option selected>Pilih Provinsi</option>
                                @foreach ($provinsiList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('request.provinsi_id')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary"><i
                                    class=" las la-search-location text-primary"></i> Pilih Kabupaten <span
                                    class="text-danger">*</span></label>
                            <select wire:model="request.kabupaten_id"
                                class="form-control @error('request.kabupaten_id') is-invalid @enderror">
                                <option selected>Pilih Kabupaten</option>
                                @foreach ($kabupatenList as $item)
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
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary"><i class=" las la-building text-primary"></i>
                                Pengelola Kepegawaian <span class="text-danger">*</span></label>
                            <select wire:model="request.instansi_initials"
                                class="form-select @error('request.instansi_initials') is-invalid @enderror">
                                <option selected>Pilih Pengelola</option>
                                <option value="1">
                                    Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota
                                </option>
                                <option value="2">Badan Kepegawaian Daerah Kota</option>
                            </select>
                            @error('request.instansi_initials')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary"><i
                                    class=" las la-search-location text-primary"></i> Pilih Provinsi <span
                                    class="text-danger">*</span></label>
                            <select wire:model="request.provinsi_id"
                                class="form-select @error('request.provinsi_id') is-invalid @enderror">
                                <option selected>Pilih Provinsi</option>
                                @foreach ($provinsiList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('request.provinsi_id')
                                <span class="invalid-feedback">
                                    <strong>{{ str_replace('request.', '', $message) }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12" id="kotaSection">
                        <div class="mb-3">
                            <label class="form-label text-body-secondary">Pilih Kota</label>
                            <select wire:model="request.kota_id"
                                class="form-control @error('request.kota_id') is-invalid @enderror">
                                <option selected>Pilih Kota</option>
                                @foreach ($kotaList as $item)
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
                <hr>
                <div class="col-md-12">
                    <div class="mb-3 has-validation">
                        <label class="form-label text-body-secondary">
                            <i class="las la-id-card text-primary"></i> Nama Lengkap
                            <span class="text-danger">*</span></label>
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
                        <label class="form-label text-body-secondary"><i class="las la-id-card text-primary"></i> NIP
                            <span class="text-danger">*</span></label>
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
