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
                        <a href="{{ route('/formasi/import') }}" class="btn btn-primary btn-sm float-end">IMPORT</a>
                    </div>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="max-width: 10% " class="">Nama</th>
                            <th class="">Dibuat Tanggal</th>
                            <th class="">Dibuat Oleh</th>
                            {{-- <th class="text-center">Formasi</th> --}}
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unitKerjaList as $index => $unitKerja)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="max-width: 10% " class="">{{ $unitKerja->name }}</td>
                                <td class="">{{ $unitKerja->created_at }}</td>
                                <td class="">{{ $unitKerja->created_by }}</td>
                                {{-- <td class="" style="font-size: 0.9rem">
                                    <div class="dropdown d-inline-block">
                                        <a href="{{ route('siap.unit_kerja.formasi', ['id' => $unitKerja->id]) }}"
                                            class="btn btn-soft-primary btn-sm " aria-expanded="false">Tambah
                                            <i class="mdi mdi-plus"></i>
                                        </a>
                                    </div>
                                </td> --}}
                                <td class="" style="font-size: 0.9rem">
                                    <div class="dropdown d-inline-block">
                                        <a href="#" class="btn btn-soft-primary btn-sm "
                                            aria-expanded="false">Detail
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
