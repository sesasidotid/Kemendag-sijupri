    <div class="d-flex justify-content-center">
        <div class="order-lg-2 order-xl-1">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-6">
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
                                    {{ $user->userDetail->tanggal_lahir }}
                                </div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Jenis Kelamin</div>
                                <div class="col">{{ $user->userDetail->jenis_kelamin }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Jabatan</div>
                                <div class="col">{{ $user->jabatan->jabatan->name ?? '' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Jenjang</div>
                                <div class="col">{{ $user->jabatan->jenjang->name ?? '' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">{{ $user->pangkat->pangkat->name ?? '' }}</div>
                                <div class="col">
                                    iii
                                </div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Unit Kerja</div>
                                <div class="col">{{ $user->unitKerja->name ?? '' }}</div>
                            </div>
                            <div class="row text-dark">
                                <div class="col-3">Alamat Unit Kerja</div>
                                <div class="col">{{ $user->unitKerja->alamat ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-body p-6">
                        <h4 class="header-title mt-1 mb-1 fw-bold font-20 text-dark p-2 ">
                            {{ $akpInstrumen->name }}
                        </h4>
                    </div>
                    @php
                        $current = 0;
                    @endphp
                    @foreach ($akpInstrumen->akpKategoriPertanyaan as $index_1 => $kategori)
                        @foreach ($kategori->akpPertanyaan as $index_2 => $pertanyaan)
                            @php
                                $current++;
                            @endphp
                            @if ($page == $current && !$isFailed)
                                <div class="card">
                                    <div class="card-body p-6">
                                        <h4 class="header-title mt-1 mb-1 fw-bold font-20 text-dark p-2 ">
                                            {{ $kategori->kategori }}
                                        </h4>
                                        <hr>
                                        <div class="card-body p-1 mt-1">
                                            <div class="row">
                                                <div class="col">
                                                    {{ $pertanyaan->pertanyaan }}
                                                </div>
                                                <div class="col">
                                                    <input wire:model="request.{{ $pertanyaan->id }}.ybs"
                                                        name="nilai" type="radio" class="btn-check"
                                                        id="option1_{{ $pertanyaan->id }}" autocomplete="off" checked
                                                        value="1">
                                                    <label class="btn btn-outline-info"
                                                        for="option1_{{ $pertanyaan->id }}">
                                                        Tidak mampu
                                                    </label>
                                                    <input wire:model="request.{{ $pertanyaan->id }}.ybs"
                                                        name="nilai" type="radio" class="btn-check"
                                                        id="option2_{{ $pertanyaan->id }}" autocomplete="off"
                                                        value="2">
                                                    <label class="btn btn-outline-info"
                                                        for="option2_{{ $pertanyaan->id }}">
                                                        Cukup mampu
                                                    </label>
                                                    <input wire:model="request.{{ $pertanyaan->id }}.ybs"
                                                        name="nilai" type="radio" class="btn-check"
                                                        id="option3_{{ $pertanyaan->id }}" autocomplete="off"
                                                        value="3">
                                                    <label class="btn btn-outline-info"
                                                        for="option3_{{ $pertanyaan->id }}">
                                                        Mampu
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-info">
                                        @if ($page != 1)
                                            <a wire:click="prefPage" class="btn btn-info float-start">
                                                <span class="mdi mdi-arrow-left"></span>Kembali
                                            </a>
                                        @endif
                                        <a wire:click="nextPage({{ $pertanyaan->id }})" class="btn btn-info float-end"
                                            data-bs-toggle="modal">
                                            Lanjut<span class="mdi mdi-arrow-right"></span>
                                        </a>
                                    </div>
                                </div>
                            @elseif($page == $current && $isFailed)
                                <div class="card card-body row">
                                    <div class="row">
                                        <h4 class="justify fw-bold text-dark">
                                            Anda dinilai belum {{ $pertanyaan->pertanyaan }}. Menurut
                                            anda, apakah penyebab ketidakmampuan tersebut dikarenakan..
                                        </h4>
                                    </div>
                                    <div class="row col-12 mb-3">
                                        <label class="col-12 form-label card card-body text-center text-dark h5">
                                            Anda Belum Mendapatkan Penugasan Tersebut
                                        </label>
                                        <div class="col-12 d-flex justify-content-sm-center">
                                            <input wire:model="request.{{ $pertanyaan->id }}.penugasan" type="radio"
                                                name="penugasan" class="btn-check"
                                                id="penugasan1_{{ $pertanyaan->id }}" autocomplete="off" checked="true"
                                                value="1">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 10%"
                                                for="penugasan1_{{ $pertanyaan->id }}">
                                                Ya
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.penugasan" type="radio"
                                                name="penugasan" class="btn-check"
                                                id="penugasan2_{{ $pertanyaan->id }}" autocomplete="off"
                                                value="0">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 10%"
                                                for="penugasan2_{{ $pertanyaan->id }}">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row col-12 mb-3">
                                        <label class="col-12 form-label card card-body text-center text-dark h5">
                                            Anda Belum Menguasai Materi Tersebut
                                        </label>
                                        <div class="col-12 d-flex justify-content-sm-center">
                                            <input wire:model="request.{{ $pertanyaan->id }}.materi" type="radio"
                                                name="materi" class="btn-check" id="materi1_{{ $pertanyaan->id }}"
                                                autocomplete="off" checked="true" value="1">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 10%"
                                                for="materi1_{{ $pertanyaan->id }}">
                                                Ya
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.materi" type="radio"
                                                name="materi" class="btn-check" id="materi2_{{ $pertanyaan->id }}"
                                                autocomplete="off" value="0">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 10%"
                                                for="materi2_{{ $pertanyaan->id }}">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row col-12 mb-3">
                                        <label class="col-12 form-label card card-body text-center text-dark h5">
                                            Anda Tidak Update Terhadap Informasi Tersebut
                                        </label>
                                        <div class="col-12 d-flex justify-content-sm-center">
                                            <input wire:model="request.{{ $pertanyaan->id }}.informasi"
                                                type="radio" name="informasi" class="btn-check"
                                                id="informasi1_{{ $pertanyaan->id }}" autocomplete="off"
                                                checked="true" value="1">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 10%"
                                                for="informasi1_{{ $pertanyaan->id }}">
                                                Ya
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.informasi"
                                                type="radio" name="informasi" class="btn-check"
                                                id="informasi2_{{ $pertanyaan->id }}" autocomplete="off"
                                                value="0">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 10%"
                                                for="informasi2_{{ $pertanyaan->id }}">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 mb-3">
                                        <label class="col-12 form-label card card-body text-center text-dark h5">
                                            Waktu Penyelesaian Pekerjaan
                                        </label>
                                        <div class="col-12 d-flex justify-content-sm-center">
                                            <input wire:model="request.{{ $pertanyaan->id }}.waktu" type="radio"
                                                name="waktu" class="btn-check" id="waktu1_{{ $pertanyaan->id }}"
                                                autocomplete="off" checked="true" value="1">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="waktu1_{{ $pertanyaan->id }}">Normal</label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.waktu" type="radio"
                                                name="waktu" class="btn-check" id="waktu2_{{ $pertanyaan->id }}"
                                                autocomplete="off" value="3">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="waktu2_{{ $pertanyaan->id }}">Lambat</label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.waktu" type="radio"
                                                name="waktu" class="btn-check" id="waktu3_{{ $pertanyaan->id }}"
                                                autocomplete="off" value="5">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="waktu3_{{ $pertanyaan->id }}">
                                                Sangat Lambat
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="col-12 form-label card card-body text-center text-dark h5">
                                            Tingkat Kesulitan Dalam Menyelesaikan Pekerjaan
                                        </label>
                                        <div class="col-12 d-flex justify-content-sm-center">
                                            <input wire:model="request.{{ $pertanyaan->id }}.kesulitan"
                                                type="radio" name="kesulitan" class="btn-check"
                                                id="kesulitan1_{{ $pertanyaan->id }}" autocomplete="off"
                                                checked="true" value="1">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="kesulitan1_{{ $pertanyaan->id }}">
                                                Normal
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.kesulitan"
                                                type="radio" name="kesulitan" class="btn-check"
                                                id="kesulitan2_{{ $pertanyaan->id }}" autocomplete="off"
                                                value="3">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="kesulitan2_{{ $pertanyaan->id }}">
                                                Sulit
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.kesulitan"
                                                type="radio" name="kesulitan" class="btn-check"
                                                id="kesulitan3_{{ $pertanyaan->id }}" autocomplete="off"
                                                value="5">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="kesulitan3_{{ $pertanyaan->id }}">
                                                Sangat Sulit
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="col-12 form-label card card-body text-center text-dark h5">
                                            Kualitas Hasil Kerja
                                        </label>
                                        <div class="col-12 d-flex justify-content-sm-center">
                                            <input wire:model="request.{{ $pertanyaan->id }}.kualitas" type="radio"
                                                name="kualitas" class="btn-check"
                                                id="kualitas1_{{ $pertanyaan->id }}" autocomplete="off"
                                                checked="true" value="1">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="kualitas1_{{ $pertanyaan->id }}">
                                                Cukup Baik
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.kualitas" type="radio"
                                                name="kualitas" class="btn-check"
                                                id="kualitas2_{{ $pertanyaan->id }}" autocomplete="off"
                                                value="3">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="kualitas2_{{ $pertanyaan->id }}">
                                                Kurang Baik
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.kualitas" type="radio"
                                                name="kualitas" class="btn-check"
                                                id="kualitas3_{{ $pertanyaan->id }}" autocomplete="off"
                                                value="5">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="kualitas3_{{ $pertanyaan->id }}">
                                                Buruk
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="col-12 form-label card card-body text-center text-dark h5">
                                            Dampak Terhadap Layanan yang Diberikan
                                        </label>
                                        <div class="col-12 d-flex justify-content-sm-center">
                                            <input wire:model="request.{{ $pertanyaan->id }}.pengaruh" type="radio"
                                                name="pengaruh" class="btn-check"
                                                id="pengaruh1_{{ $pertanyaan->id }}" autocomplete="off"
                                                checked="true" value="1">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="pengaruh1_{{ $pertanyaan->id }}">
                                                Berdampak Kecil
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.pengaruh" type="radio"
                                                name="pengaruh" class="btn-check"
                                                id="pengaruh2_{{ $pertanyaan->id }}" autocomplete="off"
                                                value="3">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="pengaruh2_{{ $pertanyaan->id }}">
                                                Berdampak Besar
                                            </label>
                                            <input wire:model="request.{{ $pertanyaan->id }}.pengaruh" type="radio"
                                                name="pengaruh" class="btn-check"
                                                id="pengaruh3_{{ $pertanyaan->id }}" autocomplete="off"
                                                value="5">
                                            <label class="btn btn-outline-info me-3 ms-3" style="width: 20%"
                                                for="pengaruh3_{{ $pertanyaan->id }}">
                                                Berdampak Sangat Besar
                                            </label>
                                        </div>
                                    </div>
                                    <div class="bg-info">
                                        <a wire:click="prefPage" class="btn btn-info float-start">
                                            <span class="mdi mdi-arrow-left"></span>Kembali
                                        </a>
                                        <a wire:click="nextPageMatrix({{ $pertanyaan->id }})"
                                            class="btn btn-info float-end" data-bs-toggle="modal">
                                            Lanjut<span class="mdi mdi-arrow-right"></span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                    @if ($page > $current)
                        <div class="card">
                            <div class="card-body p-6">
                                <h4 class="header-title mt-1 mb-1 fw-bold font-20 text-dark p-2 ">
                                    {{ $kategori->kategori }}
                                </h4>
                                <button type="submit" class="btn btn-success">
                                    simpan
                                </button>
                            </div>
                            <div class="bg-info">
                                <a wire:click="prefPage" class="btn btn-info float-start">
                                    <span class="mdi mdi-arrow-left"></span>Kembali
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
