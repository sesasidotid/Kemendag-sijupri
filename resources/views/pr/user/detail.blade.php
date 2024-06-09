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
                                    <td>{{ucfirst( $poinAKs[0]->jabatan->name)}}</td>

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
                <div class="col-md-6 shadow-sm p-2">
                    <h5 class="card-title mb-3 text-primary">Informasi Angka Kredit </h5>
                    <div class="table-responsive">
                        <table class="table  mb-0">
                            <tbody>
                                <tr>
                                    <th style="width:40%" class="ps-0" scope="row">Status Penilaian Periodik:</th>
                                    <td > @if($poinAKs[0]->status_periodik == 1)
                                        Tahunan
                                        @elseif($poinAKs[0]->status_periodik == 0)
                                        Bulanan
                                        @else
                                        Invalid Status
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:40%" class="ps-0" scope="row">Tanggal Penilaian Mulai:</th>
                                    <td > {{ \Carbon\Carbon::parse($poinAKs[0]->tanggal_mulai)->format('j-M-Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:40%" class="ps-0" scope="row">Tanggal Penilaian Selesai:</th>
                                    <td > {{ \Carbon\Carbon::parse($poinAKs[0]->tanggal_selesai)->format('j-M-Y') }}        </td>
                                </tr>
                                <tr>
                                    <th style="width:40%" class="ps-0" scope="row">Angka Kredit Total</th>
                                    <td >{{ $poinAKs[0]->ak_total }}

                                </tr>
                                <tr>
                                    <th style="width:40%" class="ps-0" scope="row">Angka Kredit Terakhir</th>
                                    <td >{{ $poinAKs[0]->ak_terakhir }}

                                </tr>
                                <tr>
                                    <th style="width:40%" class="ps-0" scope="row">Angka Kredit Terbaru</th>
                                    <td >{{ $poinAKs[0]->ak_terbaru }}</td>


                                </tr>
                                <tr>
                                    <th style="width:40%" class="ps-0" scope="row">Selisih Poin Jenjang</th>
                                    <td >{{ $poinAKs[0]->selisih_jenjang }}</td>



                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row">Maksimal Poin Jenjang</th>
                                    <td>{{ $poinAKs[0]->max_jenjang }}</td>


                                    </td>
                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row">Predikat Kinerja</th>
                                    <td>
                                        @if($poinAKs[0]->rating == 5)
                                        Sangat Baik
                                        @elseif($poinAKs[0]->rating == 4)
                                        Baik
                                        @elseif($poinAKs[0]->rating == 3)
                                        Cukup
                                        @elseif($poinAKs[0]->rating == 2)
                                        Kurang
                                        @elseif($poinAKs[0]->rating == 1)
                                        Sangat Kurang
                                        @else
                                        Invalid Rating
                                        @endif
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="col-md-6  p-2">
                    <h5 class="card-title mb-3 text-primary">Informasi Status dan Verifikasi </h5>
                    <div class="table-responsive card">
                        <table class="table  mb-0">
                            <tbody>
                                <tr>
                                    <th  class="ps-0" scope="row">Status Verifikasi</th>
                                    <td>@if($poinAKs[0]->approved == 1)
                                        <span class="badge bg-success">Sudah Verifikasi</span>
                                        @else
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <th  class="ps-0" scope="row">Status Selesai</th>
                                    <td>
                                        @if($poinAKs[0]->status_selesai == 1)
                                        <span class="badge bg-success">Sudah Selesai</span>
                                        @else
                                        <span class="badge bg-warning">Belum Selesai</span>
                                        @endif

                                    </td>

                                </tr>
                                <tr>
                                    <th  class="ps-0" scope="row">Catatan:</th>
                                    <td style="color: red;">{{ $poinAKs[0]->catatan }}

                                    </td>

                                </tr>


                            </tbody>
                        </table>
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