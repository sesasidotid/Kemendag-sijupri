@extends('layout.v_wrapper')
@section('title')
    Data Unit Kerja/Instansi Daerah
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
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Daftar Unit Kerja/Instansi Daerah
                    <a class="btn btn-primary btn-sm float-end"
                        href="{{ route('/maintenance/unit_kerja_instansi_daerah/create') }}">Tambah <i
                            class="mdi mdi-plus"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="main-table table nowrap align-middle w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Provinsi</th>
                            <th class="text-center">Kabupaten/Kota</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unitKerjaList as $index => $unitKerja)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-center">{{ $unitKerja->name }}</td>
                                <td class="text-center">{{ $unitKerja->instansi->provinsi->name ?? '-' }}</td>
                                <td class="text-center">
                                    {{ $unitKerja->instansi->kabupaten->name ?? ($unitKerja->instansi->kota->name ?? '-') }}
                                </td>
                                <td class="text-center" style="font-size: 0.9rem">
                                    <div class="dropdown d-inline-block">
                                        <a href="{{ route('/maintenance/unit_kerja_instansi_daerah/detail', ['id' => $unitKerja->id]) }}"
                                            class="btn btn-sm btn-soft-primary" aria-expanded="false">Detail
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
