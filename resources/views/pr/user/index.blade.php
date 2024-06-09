@extends('layout.v_wrapper')
@section('content')
    <div class="row">
        <div class="" id="applicationList">

            <div class="card card-header  border-0">
                <div class="d-md-flex align-items-center">
                    <h5 class="card-title mb-3 mb-md-0 flex-grow-1">Formulir Data Angka Kredit</h5>

                </div>
            </div>
            <div class="card shadow-sm p-3">



                <form action="/performing/form" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="StartleaveDate" class="form-label">Periode Penilaian</label>
                                <input type="date" name="tanggal_mulai" data-provider="flatpickr" class="form-control"
                                    id="StartleaveDate">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="EndleaveDate" class="form-label">Sampai Dengan</label>
                                <input type="date" name="tanggal_selesai" data-provider="flatpickr" class="form-control"
                                    id="EndleaveDate">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="VertimeassageInput" class="form-label">Penialaian Tahunan/Bulanan</label>
                        <select class="form-select mb-3" name="status_periodik" required
                            aria-label="Default select example">
                            <option value="" disabled selected>Pilih Periode Penilaian</option>
                            <option value="0">Periodik</option>
                            <option value="1">Tahunan</option>

                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="VertimeassageInput" class="form-label">Angka Kredit Terakhir</label>

                                <input type="text" name="ak_terakhir" placeholder="...." required class="form-control"
                                    id="StartleaveDate">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="VertimeassageInput" class="form-label">
                                    Upload Berkas Angka Kredit
                                    <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                </label>
                                <input type="file" accept=".pdf" class="form-control" name="pdf_dokumen_ak_terakhir"
                                    accept=".pdf" id="StartleaveDate">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="VertimeassageInput" class="form-label">Angka Kredit Terbaru</label>

                        <input type="text" name="ak_terbaru" placeholder="...." required required class="form-control"
                            id="StartleaveDate">
                    </div>

                    <div class="mb-3">
                        <label for="VertimeassageInput" class="form-label">Rating Predikat Kinerja</label>
                        <select class="form-select mb-3" name="rating" aria-label="Default select example">
                            <option selected disabled>Pilih Rating</option>
                            <option value="1">Sangat Kurang</option>
                            <option value="2">Kurang</option>
                            <option value="3">Cukup</option>
                            <option value="4">Baik</option>
                            <option value="5">Sangat Baik</option>


                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="VertimeassageInput" class="form-label">
                            Upload Hasil Evaluasi Kinerja
                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                        </label>
                        <input type="file" accept=".pdf" name="pdf_hsl_evaluasi_kinerja" accept=".pdf" required
                            class="form-control" id="StartleaveDate">
                    </div>
                    <div class="mb-3">
                        <label for="VertimeassageInput" class="form-label">
                            Upload Akumulasi Angka Kredit
                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                        </label>
                        <input type="file" accept=".pdf" name="pdf_akumulasi_ak_konversi" accept=".pdf"
                            class="form-control" id="StartleaveDate">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>



                .


            </div>
            <!--end row-->
        </div>
        <!--end row-->
        <!--end row-->
    @endsection
