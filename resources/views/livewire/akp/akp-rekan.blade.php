<div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-9  order-lg-2 order-xl-1">
            @if ($akpInstrumen == null)
                <div>
                    <form wire:submit.prevent="temp">
                        <div class="card card-body p-6">
                            <h4 class="header-title mt-1 mb-1 fw-bold font-20 text-dark p-2 ">
                                Review AKP
                            </h4>
                            <div class="col-md-12">
                                <div class="has-validation">
                                    <label class="form-label">
                                        <i class="mdi mdi-card-account-details mr-2"></i>
                                        NIP JF yang akan dinilai
                                    </label>
                                    <input wire:model="temp.nip"
                                        class="form-control @error('temp.nip') is-invalid @enderror" placeholder="NIP">
                                    @error('temp.nip')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('temp.', '', $message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success m-3 float-end">selanjutnya</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="row">
                    <div class="card card-body p-6">
                        <h4 class="header-title mt-1 mb-1 fw-bold font-20 text-dark">
                            Detail JF
                        </h4>
                        <hr>
                        <div class="row text-dark">
                            <div class="col-3">Nama</div>
                            <div class="col">{{ $user->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Tempat, Tanggal Lahir</div>
                            <div class="col">
                                {{ $user->userDetail->tempat_lahir }},
                                {{ substr($user->userDetail->tanggal_lahir ?? '-', 0, 10) }}
                            </div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Jenis Kelamin</div>
                            <div class="col">{{ $user->userDetail->jenis_kelamin }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Jabatan</div>
                            <div class="col">{{ $user->jabatan->jabatan->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Jenjang</div>
                            <div class="col">{{ $user->jabatan->jabatan->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Pangkat</div>
                            <div class="col">{{ $user->pangkat->pangkat->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Unit Kerja</div>
                            <div class="col">{{ $user->unitKerja->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Alamat Unit Kerja</div>
                            <div class="col">{{ $user->unitKerja->alamat }}</div>
                        </div>
                    </div>
                    <div class="card card-body p-6">
                        <h4 class="header-title mt-1 mb-1 fw-bold font-20 text-dark">
                            Masukkan Nilai Instrumen : {{ $akpInstrumen->name }}
                        </h4>
                        <hr>
                        <div class="card-body p-1 mt-1">
                            <form wire:submit.prevent="store">
                                @foreach ($akpInstrumen->AkpKategoriPertanyaan as $item)
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="text-darl fw-bold h5">{{ $item->kategori }}</p>
                                            <hr>
                                            @foreach ($item->akpPertanyaan as $value)
                                                <div class="row mb-3" wire:key="key-{{ $value->id }}">
                                                    <div class="col">
                                                        {{ $value->pertanyaan }}
                                                    </div>
                                                    <div class="col">
                                                        <input wire:model="request.{{ $value->id }}" type="radio"
                                                            class="btn-check" id="option1_{{ $value->id }}"
                                                            autocomplete="off" checked
                                                            name="request.{{ $value->id }}" value="1">
                                                        <label
                                                            class="btn btn btn-outline-primary @error('request.' . $value->id) text-danger @enderror"
                                                            for="option1_{{ $value->id }}">
                                                            Tidak mampu
                                                        </label>

                                                        <input wire:model="request.{{ $value->id }}" type="radio"
                                                            class="btn-check" id="option2_{{ $value->id }}"
                                                            autocomplete="off" name="request.{{ $value->id }}"
                                                            value="2">
                                                        <label
                                                            class="btn btn btn-outline-primary @error('request.' . $value->id) text-danger @enderror"
                                                            for="option2_{{ $value->id }}">
                                                            Cukup Mampu
                                                        </label>

                                                        <input wire:model="request.{{ $value->id }}" type="radio"
                                                            class="btn-check" id="option3_{{ $value->id }}"
                                                            autocomplete="off" name="request.{{ $value->id }}"
                                                            value="3">
                                                        <label
                                                            class="btn btn btn-outline-primary @error('request.' . $value->id) text-danger @enderror"
                                                            for="option3_{{ $value->id }}">
                                                            Mampu
                                                        </label>
                                                        @error('request.' . $value->id)
                                                            <div class="row text-danger fw-bold ms-2">
                                                                {{ str_replace('request.' . $value->id, '', $message) }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div class="row">
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                <div>
                                    <button class="btn btn-info float-end">
                                        simpan <i class=" uil-download-alt"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
