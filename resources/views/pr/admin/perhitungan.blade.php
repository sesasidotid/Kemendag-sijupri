@extends('layout.v_wrapper')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">FORM PERHITUNGAN ANGKA KREDIT</h4>
            <div class="flex-shrink-0">

            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="live-preview">
                <form action="">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i> Pilih Jenjang</label>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    </select>
                             </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="employeeUrl" class="form-label"><i class=" lab la-dochub"></i> Masukan Angka Kredit</label>
                            <input type="text" class="form-control" id="employeeUrl" placeholder="Enter emploree url">
                        </div>
                    </div>


                    <div class="text-start">
                        <button type="submit" class="btn btn-primary"><i class=" las la-save"></i> Hitung</button>
                    </div>
                </form>
                <!--end row-->
            </div>

        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">HASIL PERHITUNGAN ANGKA KREDIT</h4>
            <div class="flex-shrink-0">

            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="live-preview">
                <table class="table">
                    <thead>
                      <tr>

                        <th  scope="col" style="width: 50% ; font-size: 1rem">Informasi</th>
                        <th  scope="col" style="font-size: 1rem">Nilai</th>

                      </tr>
                    </thead>
                    <tbody>
                      <tr>

                        <td>Jenjang</td>
                        <td>Pemula</td>

                      </tr>
                      <tr>

                        <td>Angka Kredit</td>
                        <td>12</td>

                      </tr>
                      <tr>

                        <td>Pangkat/Golongan</td>
                        <td>II/a</td>

                      </tr>
                      <tr>

                        <td>Selesi Poin dari Maximal Poin Pangkat</td>
                        <td>II/a</td>

                      </tr>
                      <tr>

                        <td>Selesi Poin dari Maximal Poin Jenjang</td>
                        <td>II/a</td>

                      </tr>
                    </tbody>
                  </table>

                  <h5>Status : <span class="badge bg-success-subtle text-success">Rekomendasi Untuk UKOM</span></h5>
            </div>

        </div>
    </div>
</div>
@endsection