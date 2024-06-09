@extends('layout.v_wrapper')
@section('content')
    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="row card-header bg-light border-0">
                    <div class="col">
                        <h5 class="card-title mb-md-0 flex-grow-1">
                            Data User Jabatan Fungsional
                        </h5>
                    </div>
                    <div class="col">
                        <a href="{{ route('siap.registration.create') }}" class="btn btn-primary float-end">
                            Tambah User
                        </a>
                    </div>
                </div>
                <div class="row card-body">
                    <table id="scroll-horizontal" class="table table-bordered nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">NIP</th>
                                <th scope="col">Nama</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($userList))
                                @foreach ($userList as $index => $user)
                                    <tr>
                                        <td scope="col">{{ $index + 1 }}</td>
                                        <td scope="col">{{ $user->created_at }}</td>
                                        <td scope="col">{{ $user->nip }}</td>
                                        <td scope="col">{{ $user->name }}</td>
                                        <td scope="col" class="p-1">
                                            <a class="link-danger ps-1 border-start">
                                                hapus<i class="mdi mdi-delete-circle-outline h4 text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!--end col-->
    </div><!--end row-->
@endsection
