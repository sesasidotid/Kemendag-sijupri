@extends('layout.v_wrapper')
@section('title')
    Detail JF
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-6">
            <form method="POST" action="{{ route('/akp/daftar/export', ['id' => $akpData->id]) }}">
                @csrf
                <div class="alert alert-primary" role="alert">
                    <strong>Dibawah Ini Merupakan Data AKP Jabatan Fungsional </strong>
                    <button type="submit" class="btn btn-primary btn-sm float-end">EXPORT</button>
                </div>
            </form>
            <div class="card card-body p-6">
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
                    <div class="col">{{ $user->jabatan->jenjang->name }}</div>
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
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" active data-bs-toggle="tab" href="#matrix1" role="tab"
                                aria-selected="true">
                                Matrix 1
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#matrix2" role="tab" aria-selected="false">
                                Matrix 2
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#matrix3" role="tab" aria-selected="false">
                                Matrix 3
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#rekap" role="tab" aria-selected="false">
                                Rekap
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="matrix1" role="tabpanel">
                            <table class="main-table table table-bordered nowrap align-middle w-100">
                                <thead class="bg-light  ">
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Score YBS</th>
                                        <th>Score Rekan</th>
                                        <th>Score Atasan</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($akpData->akpMatrix))
                                        @foreach ($akpData->akpMatrix as $index => $matrix1)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $matrix1->pertanyaanAKP->pertanyaan }}</td>
                                                <td>{{ $matrix1->ybs }}</td>
                                                <td>{{ $matrix1->rekan }}</td>
                                                <td>{{ $matrix1->atasan }}</td>
                                                <td>{{ $matrix1->score_matrix_1 }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="matrix2" role="tabpanel">
                            <table class="main-table table table-bordered nowrap align-middle w-100">
                                <thead class="bg-light  ">
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Skor Penugasan</th>
                                        <th>Skor Materi</th>
                                        <th>Skor Informasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($akpData->akpMatrix))
                                        @foreach ($akpData->akpMatrix as $index => $matrix2)
                                            @if ($matrix2->score_matrix_1 < 7)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $matrix2->pertanyaanAKP->pertanyaan }}</td>
                                                    <td>{{ $matrix2->penugasan }}</td>
                                                    <td>{{ $matrix2->materi }}</td>
                                                    <td>{{ $matrix2->informasi }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="matrix3" role="tabpanel">
                            <table class="main-table table table-bordered nowrap align-middle w-100">
                                <thead class="bg-light  ">
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>waktu</th>
                                        <th>kesulitan</th>
                                        <th>kualitas</th>
                                        <th>pengaruh</th>
                                        <th>total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($akpData->akpMatrix))
                                        @foreach ($akpData->akpMatrix as $index => $matrix3)
                                            @if ($matrix3->score_matrix_1 < 7)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $matrix3->pertanyaanAKP->pertanyaan }}</td>
                                                    <td>{{ $matrix3->waktu }}</td>
                                                    <td>{{ $matrix3->kesulitan }}</td>
                                                    <td>{{ $matrix3->kualitas }}</td>
                                                    <td>{{ $matrix3->pengaruh }}</td>
                                                    <td>{{ $matrix3->score_matrix_3 }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="rekap" role="tabpanel">
                            <form method="POST" action="">
                                @csrf
                                <table class="main-table table table-bordered nowrap align-middle w-100">
                                    <thead class="bg-light  ">
                                        <tr>
                                            <th>No</th>
                                            <th>Kompetensi</th>
                                            <th>DKK</th>
                                            <th>Perioritas</th>
                                            <th>Jenis Pengembangan Kompetensi</th>
                                            <th>Jenis Pelatihan Teknis Yang Direkomendasikan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($akpData->akpMatrix))
                                            @foreach ($akpData->akpMatrix as $index => $rekap)
                                                @if ($rekap->score_matrix_1 < 7)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $rekap->pertanyaanAKP->pertanyaan }}</td>
                                                        <td>{{ $rekap->keterangan_matrix_1 }}</td>
                                                        <td>{{ $rekap->rank_prioritas_matrix_3 }}</td>
                                                        <td>{{ $rekap->jenis_pengembangan_kompetensi }}</td>
                                                        <td>
                                                            <select name="akp[{{ $rekap->id }}][pelatihan_id]"
                                                                class="form-select mb-3 @error('request.tipe_jabatan') is-invalid @enderror"
                                                                aria-label="TipeJabatan" id="TipeJabatan">
                                                                <option selected>Pilih Tipe Jabatan</option>
                                                                @foreach ($akpPelatihanList as $index => $pelatihan)
                                                                    <option value="{{ $pelatihan->id }}">
                                                                        {{ $pelatihan->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="w-100">
                                    <button class="btn btn-sm btn-primary float-end" type="submit">
                                        SIMPAN<i class="ms-1 uil-download-alt"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!--end col-->
    </div>
    <!--end row-->
@endsection
