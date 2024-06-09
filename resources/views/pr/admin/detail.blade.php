@extends('layout.v_wrapper')
@section('content')
    <div class="row">
        <div class="card" id="applicationList">

            <div class="card card-header  border-0">
                <div class="d-md-flex align-items-center">
                    <h5 class="card-title mb-3 mb-md-0 flex-grow-1">Data Users Angka Kredit</h5>

                </div>

            </div>



            <div class="card-body">



                <div class="row">
                    <div class="col-md-6 card shadow-sm p-2">
                        <h5 class="card-title mb-3 text-primary">Data Pribadi </h5>
                        <div class="table-responsive">
                            <table class="table  mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Nama Lengkap :</th>
                                        <td>{{ optional($poinAKs[0]->userDetail->user)->name }}</td>

                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">NIP :</th>
                                        <td>{{ optional($poinAKs[0]->userDetail->user)->nip }}</td>

                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">No Hp:</th>
                                        <td>{{ $poinAKs[0]->userDetail['no_hp'] }}</td>

                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Email :</th>
                                        <td>{{ $poinAKs[0]->userDetail['email'] }}</td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>


                    </div>
                    <div class="col-md-6  card shadow-sm p-2">
                        <h5 class="card-title mb-3 text-primary">Informasi Lainya </h5>
                        <div class="table-responsive">
                            <table class="table  mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Jabatan :</th>
                                        <td>{{ ucfirst($poinAKs[0]->jabatan->name) }}</td>

                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Jenjang:</th>
                                        <td>{{ $poinAKs[0]->jenjang->jenjang }}</td>

                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">TMT Jenjang:</th>
                                        <td>{{ \Carbon\Carbon::parse($poinAKs[0]->riwayatJabatan->tmt)->format('j-M-Y') }}

                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Golongan:</th>
                                        <td>{{ $poinAKs[0]->pangkat->pangkat }}</td>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>


                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <div class="col-md-11 card  p-3">
                            <div class=" border-0">


                                <form action="{{ route('poin-ak.update.angka-kredit', ['id' => $poinAKs[0]->id]) }}"
                                    method="POST" class="">
                                    @csrf
                                    @method('PUT')

                                    <div class="d-flex align-items-center bg-secondary p-2 mb-3   "
                                        style="border-radius: 10px;">
                                        <h5 class="card-title mb-3 mb-md-0 flex-grow-1 text-center text-white">
                                            Informasi Angka Kredit
                                        </h5>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="StartleaveDate" class="form-label">Periode
                                                    Penilaian</label>
                                                <input
                                                    value="{{ \Carbon\Carbon::parse($poinAKs[0]->tanggal_mulai)->format('j-M-Y') }}"
                                                    type="text" class="form-control" id="StartleaveDate">
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="EndleaveDate" class="form-label">Sampai
                                                    Dengan</label>
                                                <input type="text"
                                                    value="{{ \Carbon\Carbon::parse($poinAKs[0]->tanggal_selesai)->format('j-M-Y') }}"
                                                    class="form-control" id="EndleaveDate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label" name="status_periodik">Penialaian
                                            Tahunan/Bulanan</label>
                                        <select name="status_periodik" class="form-select mb-3"
                                            aria-label="Default select example">
                                            <option value="1"
                                                {{ $poinAKs[0]->status_periodik == 1 ? 'selected' : '' }}>Tahunan</option>
                                            <option value="0"
                                                {{ $poinAKs[0]->status_periodik == 0 ? 'selected' : '' }}>Bulanan</option>


                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">Angka Kredit
                                            Total</label>

                                        <input value="{{ $poinAKs[0]->ak_total }}" name="ak_total" type="text"
                                            class="form-control" id="StartleaveDate">
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">Angka Kredit
                                            Terakhir</label>

                                        <input put type="text" name="ak_terakhir" value="{{ $poinAKs[0]->ak_terakhir }}"
                                            type="text" class="form-control" id="StartleaveDate">
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">Angka Kredit
                                            Terbaru</label>

                                        <input type="text" name="ak_terbaru" value="{{ $poinAKs[0]->ak_terbaru }}"
                                            type="text" class="form-control" id="StartleaveDate">
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">Selisih Poin
                                            Jenjang</label>

                                        <input type="text" name="selisih_jenjang"
                                            value="{{ $poinAKs[0]->selisih_jenjang }}" class="form-control"
                                            id="StartleaveDate">
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">Maximal Poin
                                            Jenjang</label>

                                        <input type="text" name="max_jenjang" value="{{ $poinAKs[0]->max_jenjang }}"
                                            class="form-control" id="StartleaveDate">
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">Rating
                                            Predikat
                                            Kinerja</label>
                                        <select name="rating" class="form-select mb-3"
                                            aria-label="Default select example">
                                            <option value="5" {{ $poinAKs[0]->rating == 5 ? 'selected' : '' }}>Sangat
                                                Baik
                                            </option>
                                            <option value="4" {{ $poinAKs[0]->rating == 4 ? 'selected' : '' }}>Baik
                                            </option>
                                            <option value="3" {{ $poinAKs[0]->rating == 3 ? 'selected' : '' }}>Cukup
                                            </option>
                                            <option value="2" {{ $poinAKs[0]->rating == 2 ? 'selected' : '' }}>Kurang
                                            </option>
                                            <option value="1" {{ $poinAKs[0]->rating == 1 ? 'selected' : '' }}>Sangat
                                                Kurang
                                            </option>


                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">
                                            Upload Hasil Evaluasi
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <input type="file" accept=".pdf" class="form-control" id="StartleaveDate">
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">
                                            Upload Akumulasi Angka Kredit
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <input type="file" accept=".pdf" class="form-control" id="StartleaveDate">
                                    </div>

                                    <div class="d-flex align-items-center bg-secondary p-2 mb-3   "
                                        style="border-radius: 10px;">
                                        <h5 class="card-title mb-3 mb-md-0 flex-grow-1 text-center text-white">
                                            Informasi Status dan Verifikasi
                                        </h5>
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">
                                            Status Verifikasi</label>
                                        <select name="approved" class="form-select mb-3"
                                            aria-label="Default select example">
                                            <option value="1" {{ $poinAKs[0]->approved == 1 ? 'selected' : '' }}>
                                                Sudah
                                                Verifikasi</option>
                                            <option value="0" {{ $poinAKs[0]->approved == 0 ? 'selected' : '' }}>
                                                Menunggu
                                                Verifikasi</option>



                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">
                                            Status Selesai</label>
                                        <select name="status_selesai" class="form-select mb-3"
                                            aria-label="Default select example">
                                            <option value="1"
                                                {{ $poinAKs[0]->status_selesai == 1 ? 'selected' : '' }}>Sudah
                                                Selesai</option>
                                            <option value="0"
                                                {{ $poinAKs[0]->status_selesai == 0 ? 'selected' : '' }}>Belum
                                                Selesai</option>



                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="VertimeassageInput" class="form-label">
                                            Catatan</label>

                                        <textarea name="catatan" class="form-control" id="VertimeassageInput" rows="3"
                                            placeholder="Enter your message">{{ $poinAKs[0]->catatan }}</textarea>
                                    </div>
                                    <div class="text-center">
                                        <button style="width: 40%" type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div><!-- end card -->


    </div>
    <!--end row-->

    .


    </div>
    <!--end row-->
    </div>
    <!--end row-->
    <!--end row-->
@endsection
