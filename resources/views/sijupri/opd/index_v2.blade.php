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
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <table class="main-table table nowrap align-middle" style="width:100%">
                    <div class="flex-shrink-0 alert alert-primary">
                        <strong> Hi! </strong>Di bawah ini merupakan daftar <b>Unit Kerja/Instansi Daerah</b>.
                    </div>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="">Nama</th>
                            <th class="">Provinsi</th>
                            <th class="">Kabupaten/Kota</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unitKerjaList as $index => $unitKerja)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="">{{ $unitKerja->name }}</td>
                                <td class="">{{ $unitKerja->instansi->provinsi->name ?? '-' }}</td>
                                <td class="">{{ $unitKerja->instansi->kabupaten->name ?? ($unitKerja->instansi->kota->name ?? '-') }}</td>
                                <td class="" style="font-size: 0.9rem">
                                    <div class="dropdown d-inline-block">
                                        <a href="{{ route('/maintenance/unit_kerja_instansi_daerah/sijupri/detail', ['id' => $unitKerja->id]) }}"
                                            class="btn btn-soft-primary btn-sm " aria-expanded="false">
                                            Detail
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
