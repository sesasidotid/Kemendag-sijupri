@extends('layout.v_wrapper')
@section('title')
    Detail AKP JF
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header align-items-center d-flex">
                    <form method="POST" action="{{ route('/akp/daftar/export', ['id' => $akpData->id]) }}" class="w-100">
                        @csrf
                        <div class="alert alert-primary" role="alert">
                            <strong>Dibawah Ini Merupakan Data AKP Jabatan Fungsional </strong>
                            <button type="submit" class="btn btn-primary btn-sm float-end">EXPORT</button>
                        </div>
                    </form>
                </div><!-- end card header -->
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
        </div><!--end col-->
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
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#rekomendasi" role="tab" aria-selected="false">
                            Rekomendasi
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
                                    @php $i = 1 @endphp
                                    @foreach ($akpData->akpMatrix as $index => $matrix2)
                                        @if ($matrix2->score_matrix_1 < 7)
                                            <tr>
                                                <td>{{ $i++ }}</td>
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
                                    @php $i = 1 @endphp
                                    @foreach ($akpData->akpMatrix as $index => $matrix3)
                                        @if ($matrix3->score_matrix_1 < 7)
                                            <tr>
                                                <td>{{ $i++ }}</td>
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
                        <form method="POST" action="{{ route('/akp/edit_matrix') }}">
                            @csrf
                            @method('PUT')
                            <table class="main-table table table-bordered nowrap align-middle w-100">
                                <thead class="bg-light  ">
                                    <tr>
                                        <th>No</th>
                                        <th>Kompetensi</th>
                                        <th>DKK</th>
                                        <th>Perioritas</th>
                                        <th>Jenis Pengembangan Kompetensi</th>
                                        <th>Jenis Pelatihan Teknis Yang Direkomendasikan</th>
                                        <th>relevansi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($akpData->akpMatrix))
                                        @php $i = 1 @endphp
                                        @foreach ($akpData->akpMatrix as $index => $rekap)
                                            @if ($rekap->score_matrix_1 < 7)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $rekap->pertanyaanAKP->pertanyaan }}</td>
                                                    <td>{{ $rekap->keterangan_matrix_1 }}</td>
                                                    <td>{{ $rekap->rank_prioritas_matrix_3 }}</td>
                                                    <td>{{ $rekap->jenis_pengembangan_kompetensi }}</td>
                                                    <td>
                                                        <select name="matrix[{{ $rekap->id }}][akp_pelatihan_id]"
                                                            class="form-select mb-3 @error('request.tipe_jabatan') is-invalid @enderror"
                                                            aria-label="TipeJabatan" id="TipeJabatan">
                                                            <option @if (!$rekap->akp_pelatihan_id) selected @endif
                                                                value="">Pilih Kompetensi</option>
                                                            @foreach ($akpPelatihanList as $index => $pelatihan)
                                                                <option @if ($pelatihan->id == $rekap->akp_pelatihan_id) selected @endif
                                                                    value="{{ $pelatihan->id }}">
                                                                    {{ $pelatihan->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="matrix[{{ $rekap->id }}][relevansi]"
                                                            class="form-select mb-3 @error('request.tipe_jabatan') is-invalid @enderror"
                                                            aria-label="TipeJabatan" id="TipeJabatan"
                                                            style="min-width: 200px">
                                                            <option @if (!$rekap->relevansi) selected @endif
                                                                value="">Pilih Relevansi
                                                            </option>
                                                            <option @if ('Relevan' === $rekap->relevansi) selected @endif
                                                                value="Relevan">Relevan
                                                            </option>
                                                            <option @if ('Tidak Relevan' === $rekap->relevansi) selected @endif
                                                                value="Tidak Relevan">Tidak Relevan
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="w-100 mt-2">
                                <button class="btn btn-sm btn-primary float-end" type="submit">
                                    SIMPAN<i class="ms-1 uil-download-alt"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="rekomendasi" role="tabpanel">
                        <div class="card shadow-sm p-2">
                            <div class="card-body">
                                <form method="POST"
                                    action="{{ route('/akp/upload_rekomendasi', ['id' => $akpData->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="FileRekomendasi" class="form-label">
                                                    <span class="text-danger fw-bold">*</span>
                                                    File Rekomendasi
                                                    <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                                </label>
                                                <input name="file_rekomendasi" type="file" accept=".pdf"
                                                    class="form-control" id="FileRekomendasi" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary btn-sm float-end m-1">
                                                Upload
                                            </button>
                                        </div>
                                        <hr>
                                        <div class="col-12">
                                            <iframe id="previewIframe" width="100%" height="600px"
                                                src="{{ asset($akpData->file_rekomendasi ? 'storage/' . $akpData->file_rekomendasi : 'rekomendasi') }}">
                                            </iframe>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!--end row-->
@endsection
