@extends('layout.v_wrapper')
@section('title')
    Data Admin Unit Kerja/Instansi Daerah
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.tables_s')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <form method="GET" action="">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 alert alert-primary">
                            Daftar Admin Unit Kerja/Instansi Daerah
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nip</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[nip]">
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nama</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[name]">
                        </div>
                    </div>
                    <div class="w-100">
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Cari</button>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <div>
                    <table class="main-table table nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Unit Kerja/Instansi Daerah</th>
                                <th class="text-center">Provinsi</th>
                                <th class="text-center">Kabupaten/Kota</th>
                                <th class="text-center">Status User</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userList as $index => $user)
                                <tr>
                                    <td style="font-size: 0.9rem">{{ $index + 1 }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">{{ $user->nip }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">{{ $user->name ?? '-' }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">{{ $user->unitKerja->name ?? '-' }}
                                    </td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        {{ $user->instansi->provinsi->name ?? '-' }}
                                    </td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        {{ $user->instansi->kabupaten->name ?? ($user->instansi->kota->name ?? '-') }}
                                    </td>
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
                                            <a href="/user/admin_unit_kerja_instansi_daerah/detail/{{ $user->nip }}"
                                                class="btn btn-soft-primary btn-sm " aria-expanded="false">
                                                Detail <i class="mdi mdi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $userList->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
