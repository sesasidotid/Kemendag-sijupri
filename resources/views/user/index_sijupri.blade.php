@extends('layout.v_wrapper')
@section('title')
    DATA ADMIN SIjuPRI
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <form method="GET" action="">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 alert alert-primary w-100">
                            <strong> Daftar Admin Sijupri</strong>
                            <a href="{{ route('/registration/sijupri') }}" class="btn btn-primary btn-sm float-end">Tambah
                                <i class="mdi mdi-plus"></i> </a>
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
                                <th class="text-center">NIP</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userList as $index => $user)
                                <tr>
                                    <td style="font-size: 0.9rem">{{ $index + 1 }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">{{ $user->nip }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">{{ $user->name }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">{{ $user->role->name }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        <div class="dropdown d-inline-block">
                                            <a href="{{ route('/security/user/detail', $user->nip) }} "
                                                class="btn btn-soft-primary btn-sm " aria-expanded="false">
                                                Detail <i class="mdi mdi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $userList->appends(request()->query())->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
