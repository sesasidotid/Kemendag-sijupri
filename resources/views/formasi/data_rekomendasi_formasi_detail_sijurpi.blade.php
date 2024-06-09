@extends('layout.v_wrapper')
@section('title')
    Data Rekomendasi & Formasi
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
                    <a class="btn btn-sm btn-primary float-end ms-1"
                        href="{{ route('/formasi/data_rekomendasi_formasi/export_formasi', ['unit_kerja_id' => $unitKerja->id]) }}">
                        Export
                    </a>
                    Data Unit Kerja/Instansi & Rekomendasi Formasi
                    <a class="btn btn-sm btn-primary float-end"
                        href="{{ route('/formasi/data_rekomendasi_formasi/upload_rekomendasi', ['unit_kerja_id' => $unitKerja->id]) }}">
                        Rekomendasi
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="row text-dark">
                            <div class="col-3"><b>Unit Kerja/Instansi Daerah</b></div>
                            <div class="col"><b>{{ $unitKerja->name ?? '-' }}</b></div>
                        </div>
                        <hr>
                        @if ($unitKerja->instansi->provinsi_id)
                            <div class="row text-dark">
                                <div class="col-3">Provinsi</div>
                                <div class="col">{{ $unitKerja->instansi->provinsi->name ?? '-' }}</div>
                            </div>
                        @endif
                        @if ($unitKerja->instansi->kabupaten_id)
                            <div class="row text-dark">
                                <div class="col-3">Provinsi</div>
                                <div class="col">{{ $unitKerja->instansi->kabupaten->name ?? '-' }}</div>
                            </div>
                        @endif
                        @if ($unitKerja->instansi->kota_id)
                            <div class="row text-dark">
                                <div class="col-3">Provinsi</div>
                                <div class="col">{{ $unitKerja->instansi->kota->name ?? '-' }}</div>
                            </div>
                        @endif
                        <div class="row text-dark">
                            <div class="col-3">Alamat</div>
                            <div class="col">{{ $unitKerja->alamat ?? '-' }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Email</div>
                            <div class="col">{{ $unitKerja->email ?? '-' }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Nomor Telepon</div>
                            <div class="col">{{ $unitKerja->phone ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="main-table table table-bordered nowrap align-middle w-100">
                    <thead class="bg-light  ">
                        <tr>
                            <th>No</th>
                            <th>Formasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($formasiList))
                            @foreach ($formasiList as $index => $formasi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $formasi->jabatan->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('/formasi/data_rekomendasi_formasi/detail_formasi', $formasi->id) }}"
                                            class="btn btn-sm btn-soft-primary">
                                            Detail Formasi
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @include('widget.modal-doc')
            </div>
        </div>
    </div>
@endsection
