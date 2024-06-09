@extends('layout.v_wrapper')
@section('content')
<div class="row">
    <div class="card" id="applicationList">

        <div class="card card-header  border-0">
            <div class="d-md-flex align-items-center">
                <h5 class="card-title mb-3 mb-md-0 flex-grow-1">Data Performance Review Users</h5>

            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">

                    <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
                        <thead class="bg-light  ">
                            <tr>

                                <th>No</th>

                                <th>NAMA</th>
                                <th>Jabatan</th>
                                <th>Jenjang</th>
                                <th>TMT Jenjang</th>
                                <th>Pangkat</th>
                                <th>Penilaian</th>
                                <th>PAK Terakhir</th>
                                <th>PAK Terbaru</th>
                                <th>PAK Total</th>
                                <th>PAK Maximal Jenjang</th>
                                <th>Selesai Jenjang</th>

                                <th>Rating</th>
                                <th>Status Selesai</th>
                                <th>Status Verifikasi</th>
                                <th class="text-center">Berkas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($poinAKs as $index => $data)

                            <tr>

                                <td>{{ $index+1 }}</td>


                                <td>{{ optional($data->userDetail->user)->name }}</td>
                                <td>{{ ucfirst($data->jabatan->name) }}</td>

                                <td>{{ $data->jenjang->jenjang }}</td>

                                <td>{{ \Carbon\Carbon::parse($data->riwayatJabatan->tmt)->format('d M Y') }}</td>
                                <td>{{ $data->pangkat->pangkat }}</td>
                                <td>@if($data->status_periodik == 1)
                                    Tahunan
                                    @else
                                    Bulanan
                                    @endif
                                </td>
                                <td class="text-center">{{ $data->ak_terakhir }}</td>
                                <td class="text-center">{{ $data->ak_terbaru }}</td>
                                <td class="text-center">{{ $data->ak_total }}</td>
                                <td class="text-center">{{ $data->max_jenjang }}</td>
                                <td class="text-center">{{ $data->selisih_jenjang }}</td>

                                <td>
                                    @if($data->rating == 5)
                                    Sangat Baik
                                    @elseif($data->rating == 4)
                                    Baik
                                    @elseif($data->rating == 3)
                                    Cukup
                                    @elseif($data->rating == 2)
                                    Kurang
                                    @elseif($data->rating == 1)
                                    Sangat Kurang
                                    @else
                                    Invalid Rating
                                    @endif
                                </td>
                                <td id="status_selesai_{{ $data->id }}">
                                    @if($data->status_selesai)
                                    <span class="badge bg-success">Sudah Selesai</span>
                                    @else
                                    <span class="badge bg-warning">Belum Selesai</span>
                                    @endif
                                </td>

                                <td id="approved_{{ $data->id }}">
                                    @if($data->approved)
                                    <span class="badge bg-success">Sudah Verifikasi</span>


                                    @else
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>

                                    @endif
                                </td>
                                <td class="text-center">

                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="javascript:void(0);"
                                            onclick="openPDF('{{ asset('storage/' . $data->pdf_hsl_evaluasi_kinerja) }}')"
                                            class="btn btn-ghost-primary waves-effect waves-light"><i
                                                class="mdi mdi-eye"></i> AK Terakhir</a>
                                        <a href="javascript:void(0);"
                                            onclick="openPDF('{{ asset('storage/' . $data->pdf_hsl_evaluasi_kinerja) }}')"
                                            class="btn btn-ghost-primary waves-effect waves-light"><i
                                                class="mdi mdi-eye"></i> Hasil Evaluasi Akumulasi Angka
                                            Kredit</a>
                                        <a href="javascript:void(0);"
                                            onclick="openPDF('{{ asset('storage/' . $data->pdf_akumulasi_ak_konversi) }}')"
                                            class="btn btn-ghost-primary waves-effect waves-light"><i
                                                class="mdi mdi-eye"></i> Konversi</a>
                                    </div>
                                </td>
                                <td>
                                    <a href="/performing/poin_ak/user-edit/{{ $data->user_id }}"
                                        class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i>
                                        Detail</a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
</div>
<script>
    function openPDF(pdfPath){
            window.open(pdfPath, '_blank');
        }
</script>
<!--end row-->
<!--end row-->
@endsection