@extends('layout.v_wrapper')
@section('title')
    DATA PEJABAT FUNGSIONAL
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <form method="GET" action="">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 alert alert-primary w-100">
                            Data Pejabat Fungsional Kemendag
                            <a href="{{ route('/registration/user') }}" class="btn btn-primary btn-sm float-end">
                                Tambah <i class="mdi mdi-plus"></i>
                            </a>
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
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userList as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $user->nip }}</td>
                                    <td class="text-center">{{ $user->name }}</td>
                                    <td class="text-center">{{ $user->unitKerja->name ?? '-' }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        <div class="dropdown d-inline-block">
                                            <a href="{{ route('/user/user_jf/detail', ['nip' => $user->nip]) }}"
                                                class="btn btn-soft-primary btn-sm " aria-expanded="false">Detail
                                                <i class="mdi mdi-eye"></i>
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
