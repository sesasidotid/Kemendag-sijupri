@extends('layout.v_wrapper')
@section('title')
    Daftar Pendaftaran UKom
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 31px !important;
        }

        .select2-selection__arrow {
            height: 31px !important;
        }
    </style>
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.tables_s')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <form method="GET" action="">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 alert alert-primary w-100">
                            Penaftaran Periode UKom
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nip</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[nip]"
                                value="{{ request('attr.nip') }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nama</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[name]"
                                value="{{ request('attr.name') }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0">Status</label>
                            <select class="js-example-basic-single" name="attr[task_status]">
                                <option @if (request('attr.task_status')) selected @endif value="">
                                    Semua
                                </option>
                                <option @if (request('attr.task_status') == 'APPROVE') selected @endif value="APPROVE">
                                    Diterima
                                </option>
                                <option @if (request('attr.task_status') == 'PENDING') selected @endif value="PENDING">
                                    Menunggu Verifikasi
                                </option>
                                <option @if (request('attr.task_status') == 'REJECT') selected @endif value="REJECT">
                                    Ditolak
                                </option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0">Periode</label>
                            <select class="js-example-basic-single" name="attr[ukom_periode_id]">
                                @if (isset($ukomPeriodeList))
                                    @foreach ($ukomPeriodeList as $index => $ukomPeriode)
                                        <option value="{{ $ukomPeriode->id }}"
                                            {{ request('attr.ukom_periode_id') == $ukomPeriode->id ? 'selected' : '' }}>
                                            {{ date('F Y', strtotime($ukomPeriode->periode)) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-3 mt-2">
                            <label for="" class="m-0 p-0">Provinsi</label>
                            <select class="js-example-basic-single" name="attr[unitKerja][provinsi_id]">
                                <option value="">Pilih Provinsi</option>
                                @if (isset($provinsiList))
                                    @foreach ($provinsiList as $index => $provinsi)
                                        <option value="{{ $provinsi->id }}"
                                            {{ request('attr.unitKerja.provinsi_id') == $provinsi->id ? 'selected' : '' }}>
                                            {{ $provinsi->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-3 mt-2">
                            <label for="" class="m-0 p-0">Kabupaten/Kota</label>
                            <select class="js-example-basic-single" name="attr[unitKerja][kab_kota_id]">
                                <option value="">Pilih Kabupaten/Kota</option>
                                @if (isset($kabKotaList))
                                    @foreach ($kabKotaList as $index => $kabkota)
                                        <option value="{{ $kabkota->id }}"
                                            {{ request('attr.unitKerja.kab_kota_id') == $kabkota->id ? 'selected' : '' }}>
                                            {{ $kabkota->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-3 mt-2">
                            <label for="" class="m-0 p-0">Instansi</label>
                            <select class="js-example-basic-single" name="attr[unitKerja][instansi_id]">
                                <option value="">Pilih Instansi</option>
                                @if (isset($instansiList))
                                    @foreach ($instansiList as $index => $instansi)
                                        <option value="{{ $instansi->id }}"
                                            {{ request('attr.unitKerja.instansi_id') == $instansi->id ? 'selected' : '' }}>
                                            {{ $instansi->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-3 mt-2">
                            <label for="" class="m-0 p-0">Unit Kerja/Instansi Daerah</label>
                            <select class="js-example-basic-single" name="attr[unitkerja_id]">
                                <option value="">Pilih Unit Kerja/Instansi Daerah</option>
                                @if (isset($unitKerjaList))
                                    @foreach ($unitKerjaList as $index => $unitkerja)
                                        <option value="{{ $unitkerja->id }}"
                                            {{ request('attr.unitkerja_id') == $unitkerja->id ? 'selected' : '' }}>
                                            {{ $unitkerja->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="w-100">
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Cari</button>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <div>
                    <table class="main-table table table-nowrap table-striped-columns mb-0 w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Pendaftaran</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>jabatan -> tujuan</th>
                                <th>jenjang -> tujuan</th>
                                <th>pangkat -> tujuan</th>
                                <th>Diajukan Tanggal</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($ukomList))
                                @foreach ($ukomList as $index => $ukom)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ date('F Y', strtotime($ukom->ukomPeriode->periode)) }}</td>
                                        <td>{{ $ukom->jenis }}</td>
                                        <td>{{ $ukom->nip }}</td>
                                        <td>{{ ucfirst($ukom->name) }}</td>
                                        <td class="text-info">
                                            {{ $ukom->detail->jabatan_name }} ->
                                            {{ $ukom->detail->tujuan_jabatan_name }}
                                        </td>
                                        <td class="text-info">
                                            {{ $ukom->detail->jenjang_name }} ->
                                            {{ $ukom->detail->tujuan_jenjang_name }}
                                        </td>
                                        <td class="text-info">
                                            {{ $ukom->detail->pangkat_name }} ->
                                            {{ $ukom->detail->tujuan_pangkat_name }}
                                        </td>
                                        <td>{{ $ukom->created_at }}</td>
                                        <td>
                                            @if ($ukom->task_status == 'PENDING')
                                                <span class="badge bg-warning-subtle text-warning">Menunggu
                                                    Verifikasi</span>
                                            @endif
                                            @if ($ukom->task_status == 'REJECT')
                                                <span class="badge bg-warning-danger text-danger">Ditolak</span>
                                            @endif
                                            @if ($ukom->task_status == 'APPROVE')
                                                <span class="badge bg-success-subtle text-success">Diterima</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('/ukom/pendaftaran/detail', ['id' => $ukom->id]) }}"
                                                class="btn btn-sm btn-soft-primary">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                {{ $ukomList->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
