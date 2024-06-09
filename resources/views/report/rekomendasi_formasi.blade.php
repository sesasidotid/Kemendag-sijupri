@extends('layout.v_wrapper')
@section('title')
    Report Rekomendasi Formasi
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
            <div class="card-header">
                <div class="col-12 alert alert-primary w-100">
                    Generate Report Rekomendasi Formasi
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('/report/rekomendasi_formasi/generate') }}">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="" class="m-0 p-0">Unit Kerja/Instansi Daerah</label>
                            <select class="js-example-basic-single" style="height: 100px" name="params[unit_kerja_id]">
                                <option value="0">Semua</option>
                                @if (isset($unitKerjaList))
                                    @foreach ($unitKerjaList as $index => $unitKerja)
                                        <option value="{{ $unitKerja->id }}"
                                            {{ request('params[unit_kerja_id]') == $unitKerja->id ? 'selected' : '' }}>
                                            {{ $unitKerja->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="" class="m-0 p-0">Tipe File</label>
                            <select class="js-example-basic-single" style="height: 100px" name="file_type">
                                <option value="">Pilih Tipe File</option>
                                <option value="xlsx" {{ request('file_type') == 'xlsx' ? 'selected' : '' }}>
                                    .xlsx
                                </option>
                                <option value="csv" {{ request('file_type') == 'csv' ? 'selected' : '' }}>
                                    .csv
                                </option>
                                <option value="pdf" {{ request('file_type') == 'pdf' ? 'selected' : '' }}>
                                    .pdf
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="w-100">
                        <button type="submit" class="btn btn-sm btn-success float-end">Generate</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <form method="GET" action="">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 alert alert-primary w-100">
                            Daftar Report Rekomendasi Formasi
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nama File</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[filename]"
                                value="{{ request('attr[filename]') }}">
                        </div>
                    </div>
                    <div class="w-100">
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Cari</button>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <div>
                    <table class="main-table table table-bordered nowrap align-middle w-100" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Nama File</th>
                                <th class="text-center">Format file</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($reportList))
                                @foreach ($reportList as $index => $report)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $report->filename }}</td>
                                        <td class="text-center">{{ $report->file_type }}</td>
                                        <td class="text-center">{{ $report->created_at }} </td>
                                        <th class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('/report/download', ['id' => $report->id]) }}"
                                                    class="btn btn-sm btn-soft-success">
                                                    Unduh
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('/report/hapus', ['id' => $report->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-soft-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                {{ $reportList->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
