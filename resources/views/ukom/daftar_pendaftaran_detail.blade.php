@extends('layout.v_wrapper')
@section('title')
    Detail Pendaftaran UKom
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div class="flex-shrink-0 alert alert-primary">
                    Detail Penaftaran Periode UKom
                </div>
                <div class="row">
                    <div class="col">
                        <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#dataDiri" role="tab">
                                    Data Pendaftaran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#pendidikan" role="tab">
                                    Riwayat Pendidikan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#pak" role="tab">
                                    Riwayat Kinerja
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kompetensi" role="tab">
                                    Riwayat Kompetensi
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content ">
                            <div class="tab-pane active" id="dataDiri" role="tabpanel">
                                <form method="POST"
                                    action="{{ route('/ukom/pendaftaran/approval', ['id' => $ukom->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row text-dark">
                                                <div class="col-3">Periode</div>
                                                <div class="col">
                                                    {{ date('F Y', strtotime($ukom->ukomPeriode->periode)) }}</div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">Nama</div>
                                                <div class="col">{{ $ukom->name }}</div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">Tempat, Tanggal Lahir</div>
                                                <div class="col">
                                                    {{ $ukom->detail->tempat_lahir ?? '' }},
                                                    {{ substr($ukom->detail->tanggal_lahir ?? '', 0, 10) }}
                                                </div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">Jenis Kelamin</div>
                                                <div class="col">{{ $ukom->detail->jenis_kelamin ?? '' }}</div>
                                            </div>
                                            @if (isset($ukom->detail->karpeg) && $ukom->detail->karpeg != null)
                                                <div class="row text-dark">
                                                    <div class="col-3">Nomor Kartu Pegawai</div>
                                                    <div class="col">{{ $ukom->detail->karpeg ?? '' }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if (isset($ukom->detail->tmt_cpns) && $ukom->detail->tmt_cpns != null)
                                                <div class="row text-dark">
                                                    <div class="col-3">TMT CPNS</div>
                                                    <div class="col">{{ $ukom->detail->tmt_cpns ?? '' }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row text-dark">
                                                <div class="col-3">Jabatan</div>
                                                <div class="col">{{ $ukom->detail->jabatan_name ?? '' }}
                                                </div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">Jenjang</div>
                                                <div class="col">{{ $ukom->detail->jenjang_name ?? '' }}
                                                </div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">TMT Jabatan</div>
                                                <div class="col">{{ $ukom->detail->tmt_jabatan ?? '' }}
                                                </div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">Pangkat</div>
                                                <div class="col">{{ $ukom->detail->pangkat_name ?? '' }}
                                                </div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">TMT Pangkat</div>
                                                <div class="col">{{ $ukom->detail->tmt_pangkat ?? '' }}
                                                </div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">Unit Kerja</div>
                                                <div class="col">{{ $ukom->detail->unit_kerja_name ?? '' }}</div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">Alamat Unit Kerja</div>
                                                <div class="col">{{ $ukom->detail->unit_kerja_alamat ?? '' }}</div>
                                            </div>
                                            <hr>
                                            <div class="row text-dark">
                                                <div class="col-3">Jabatan Tujuan</div>
                                                <div class="col">{{ $ukom->detail->tujuan_jabatan_name ?? '' }}</div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">Jenjang Tujuan</div>
                                                <div class="col">{{ $ukom->detail->tujuan_jenjang_name ?? '' }}</div>
                                            </div>
                                            <div class="row text-dark">
                                                <div class="col-3">pangkat Tujuan</div>
                                                <div class="col">{{ $ukom->detail->tujuan_pangkat_name ?? '' }}</div>
                                            </div>
                                            @foreach ($ukom->storage as $index => $storage)
                                                <div class="row text-dark">
                                                    <div class="col-3">{{ $storage->name }}</div>
                                                    <div class="col">
                                                        <a class="link-info" href="javascript:void(0);"
                                                            onclick="previewModal({{ json_encode($storage->file) }}, {{ json_encode($storage->name) }})">
                                                            Preview <i class=" las la-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col btn-group">
                                                        <div><input type="radio" class="btn-sm btn-check"
                                                                name="storage[{{ $storage->id }}}[task_status]"
                                                                id="terima_{{ $index }}" autocomplete="off" checked
                                                                value="APPROVE">
                                                            <label class="btn btn-sm btn-outline-success"
                                                                for="terima_{{ $index }}">
                                                                Terima
                                                            </label>
                                                        </div>
                                                        <div><input type="radio" class="btn-sm btn-check"
                                                                name="storage[{{ $storage->id }}}[task_status]"
                                                                id="tolak_{{ $index }}" autocomplete="off"
                                                                value="REJECT">
                                                            <label class="btn btn-sm btn-outline-danger"
                                                                for="tolak_{{ $index }}">
                                                                Tolak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-sm btn-success float-end"
                                                value="APPROVE" name="task_status">
                                                Approve <i class=" las la-save"></i>
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-danger float-end me-2"
                                                value="REJECT" name="task_status">
                                                Reject <i class=" las la-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="pendidikan" role="tabpanel">
                                <table class="main-table table table-nowrap table-striped-columns mb-0 w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pendidikan</th>
                                            <th>Instansi</th>
                                            <th>Jurusan</th>
                                            <th>File Ijazah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($userPendidikanList))
                                            @foreach ($userPendidikanList as $index => $pendidikan)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $pendidikan->level }}</td>
                                                    <td>{{ $pendidikan->instansi_pendidikan }}</td>
                                                    <td>{{ $pendidikan->jurusan }}</td>
                                                    <td>
                                                        <a class="link-info" href="javascript:void(0);"
                                                            onclick="previewModal({{ json_encode($pendidikan->file_ijazah) }}, 'File Ijazah')">
                                                            Lihat <i class=" las la-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="pak" role="tabpanel">
                                <table class="main-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahunan/Bulanan</th>
                                            <th>Tanggal Mulai - Selesai</th>
                                            <th>Nilai Kinerja</th>
                                            <th>Nilai Perilaku</th>
                                            <th>Predikat</th>
                                            <th>Angka Kredit</th>
                                            <th>Dokumen Angka Kredit</th>
                                            <th>Dokumen Konversi Predikat Kinerja</th>
                                            <th>Hasil Evaluasi</th>
                                            <th>Akumulasi Angka Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($userPakList))
                                            @foreach ($userPakList as $index => $userPak)
                                                <tr>
                                                    <td scope="col">{{ $index + 1 }}</td>
                                                    <td scope="col">
                                                        {{ $userPak->periode == 1 ? 'Periodik' : 'Tahunan' }}
                                                    </td>
                                                    <td scope="col">{{ $userPak->tgl_mulai }} -
                                                        {{ $userPak->tgl_selesai }}</td>
                                                    <td scope="col">{{ $userPak->nilai_kinerja }}</td>
                                                    <td scope="col">{{ $userPak->nilai_perilaku }}</td>
                                                    <td scope="col">{{ $userPak->predikat }}</td>
                                                    <td scope="col">{{ $userPak->angka_kredit }}</td>
                                                    <td scope="col">
                                                        <a class="link-info" href="javascript:void(0);"
                                                            onclick="previewModal({{ json_encode($userPak->file_doc_ak) }}, 'Dokumen Angka Kredit')">
                                                            Lihat <i class=" las la-eye"></i>
                                                        </a>
                                                    </td>
                                                    <td scope="col">
                                                        <a class="link-info" href="javascript:void(0);"
                                                            onclick="previewModal({{ json_encode($userPak->file_dok_konversi) }}, 'Dokumen Konversi Predikat Kinerja')">
                                                            Lihat <i class=" las la-eye"></i>
                                                        </a>
                                                    </td>
                                                    <td scope="col">
                                                        <a class="link-info" href="javascript:void(0);"
                                                            onclick="previewModal({{ json_encode($userPak->file_hasil_eval) }}, 'Hasil Evaluasi')">
                                                            Lihat <i class=" las la-eye"></i>
                                                        </a>
                                                    </td>
                                                    <td scope="col">
                                                        <a class="link-info" href="javascript:void(0);"
                                                            onclick="previewModal({{ json_encode($userPak->file_akumulasi_ak) }}, 'Akumulasi Angka Kredit')">
                                                            Lihat <i class=" las la-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="kompetensi" role="tabpanel">
                                <table class="main-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kompetensi</th>
                                            <th>Kategori Pengembangan</th>
                                            <th>File Sertifikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($userKompetensiList))
                                            @foreach ($userKompetensiList as $index => $kompetensi)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $kompetensi->name }}</td>
                                                    <td>{{ $kompetensi->kategori }}</td>
                                                    <td>
                                                        <a class="link-info" href="javascript:void(0);"
                                                            onclick="previewModal({{ json_encode($kompetensi->file_sertifikat) }}, 'Sertifikat')">
                                                            Lihat <i class=" las la-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('widget.modal-doc')
    </div>
@endsection
