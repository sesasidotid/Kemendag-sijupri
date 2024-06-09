@extends('layout.v_wrapper')
@section('title')
    Data Pejabat Fungsional Kemendag
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div class="flex-shrink-0 alert alert-primary">
                    <strong> Hi! </strong>Di bawah ini merupakan daftar <i>user</i>/Pejabat fungsional pada Unit Kerja
                    <b>Nama Unit Kerja</b> Klik tombol tambah bila ingin menambah user.
                    <a class="btn btn-primary btn-sm" href="{{ route('/registration/user') }}">
                        Tambah<i class="mdi mdi-plus"></i>
                    </a>
                </div>
                <table class="main-table table display nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size: 0.9rem">No</td>
                            <td class="text-center" style="font-size: 0.9rem">Nama</td>
                            <td class="text-center" style="font-size: 0.9rem">Nip</td>
                            <td class="text-center" style="font-size: 0.9rem">
                                <div class="dropdown d-inline-block">
                                    <a href="/opd/user/detail" class="btn btn-soft-primary btn-sm "
                                        aria-expanded="false">Detail
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
