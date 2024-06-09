@extends('layout.v_wrapper')
@section('title')
    Daftar Rekomendasi Unit Kerja/Instansi Daerah
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
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Daftar Unit Kerja/Instansi Daerah Pemilik Formasi
                </div>
            </div>
            <form method="GET" action="">
                <div class="row card-body">
                    <div class="col-3">
                        <label for="" class="m-0 p-0"><small>Nama Unit Kerja/Instansi Daerah</small></label>
                        <input type="text" class="form-control form-control-sm" name="attr[name]"
                            value="{{ request('attr.name') }}">
                    </div>
                    <div class="col-3">
                        <label for="" class="m-0 p-0">Status</label>
                        <select class="form-control form-control-sm" name="attr[formasi][rekomendasi_flag]">
                            <option @if (request('attr.formasi.rekomendasi_flag')) selected @endif value="">
                                Semua
                            </option>
                            <option @if (request('attr.formasi.rekomendasi_flag') == 'true') selected @endif value="true">
                                Sudah Diupload
                            </option>
                            <option @if (request('attr.formasi.rekomendasi_flag') == 'false') selected @endif value="false">
                                Menunggu Rekomendasi
                            </option>
                            <option @if (request('attr.formasi.rekomendasi_flag') == 'null') selected @endif value="null">
                                Tidak Ada Formasi
                            </option>
                        </select>
                    </div>
                </div>
                <div class="w-100">
                    <button type="submit" class="btn btn-sm btn-primary mb-3 ms-3">Cari</button>
                </div>
            </form>
        </div>
        <div class="card card-body">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit Kerja/Instansi Daerah</th>
                        <th>Provinsi</th>
                        <th>Kabupaten/Kota</th>
                        <th>Status Rekomendasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($unitKerjaList)
                        @foreach ($unitKerjaList as $index => $unitKerja)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $unitKerja->name }}</td>
                                <td>{{ $unitKerja->instansi->provinsi->name ?? '-' }}</td>
                                <td>{{ $unitKerja->instansi->kabupaten->name ?? ($unitKerja->instansi->kota->name ?? '-') }}
                                </td>
                                <td>
                                    @if (isset($unitKerja->formasiDokumen) &&
                                            !$unitKerja->formasiDokumen->inactive_flag &&
                                            $unitKerja->formasiDokumen->task_status == 'APPROVE')
                                        <span class="badge bg-danger">Menunggu Rekomendasi</span>
                                    @elseif(isset($unitKerja->formasiDokumen) &&
                                            $unitKerja->formasiDokumen->inactive_flag &&
                                            $unitKerja->formasiDokumen->task_status == 'APPROVE' &&
                                            $unitKerja->file_rekomendasi_formasi)
                                        <span class="badge bg-success">Sudah Diupload</span>
                                    @else
                                        <span class="badge bg-light text-dark">Tidak Ada Formasi</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-soft-primary"
                                        href="{{ route('/formasi/data_rekomendasi_formasi/detail', ['id' => $unitKerja->id]) }}">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $unitKerjaList->appends(request()->query())->onEachSide(1)->links() }}
            @include('widget.modal-doc')
        </div>
    </div>
@endsection
