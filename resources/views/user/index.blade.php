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
                <table class="main-table table nowrap align-middle" style="width:100%">
                    <div class="flex-shrink-0 alert alert-primary">
                        <!-- Primary Alert -->
                        <strong> Hi! </strong>Di bawah ini merupakan daftar <i>user</i>/Pejabat fungsional yang telah di
                        buat oleh <b>Admin Unit Kerja/Instansi Daerah</b>
                    </div>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">Unit Kerja/Instansi Daerah</th>
                            <th class="text-center">Status User</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userList as $index => $user)
                            <tr>
                                <td style="font-size: 0.9rem">{{ $index + 1 }}</td>
                                <td class="text-center" style="font-size: 0.9rem">{{ $user->name }}</td>
                                <td class="text-center" style="font-size: 0.9rem">{{ $user->nip }}</td>
                                <td class="text-center" style="font-size: 0.9rem">{{ $user->unitKerja->name ?? '-' }}</td>
                                <td class="text-center" style="font-size: 0.9rem">
                                    @if ($user->user_status == 'DELETED')
                                        <span class="badge bg-danger">
                                            Terhapus
                                        </span>
                                    @elseif ($user->user_status == 'NOT_ACTIVE')
                                        <span class="badge bg-warning">
                                            Tidak Aktif
                                        </span>
                                    @elseif ($user->user_status == 'ACTIVE')
                                        <span class="badge bg-success">
                                            Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center" style="font-size: 0.9rem">
                                    <div class="dropdown d-inline-block">
                                        <a href="/opd/user/detail/{{ $user->nip }}" class="btn btn-soft-primary btn-sm "
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
