@extends('layout.v_wrapper')
@section('title')
    Data Provinsi
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.tables_s')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form method="POST" action="{{ route('/maintenance/provinsi/store') }}" class="mb-3">
                        @csrf
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="Nama" class="form-label">
                                    Nama
                                </label>
                                <input type="text" class="form-control" name="name" id="Nama"
                                    placeholder="Masukkan Nama">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="Deskripsi" class="form-label">
                                    Deskripsi
                                </label>
                                <input type="text" class="form-control" name="description" id="Deskripsi"
                                    placeholder="Masukkan Deskripsi">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-sm btn-soft-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <table class="main-table  table table-bordered nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($provinsiList))
                                @foreach ($provinsiList as $index => $provinsi)
                                    <tr>
                                        <td scope="col">{{ $index + 1 }}</td>
                                        <td scope="col">{{ $provinsi->name }}</td>
                                        <td scope="col" class="text-cemter">
                                            <a href="{{ route('/maintenance/provinsi/detail', ['id' => $provinsi->id]) }}"
                                                class="btn btn-sm btn-soft-primary">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{-- {{ $provinsiList->appends(request()->query())->onEachSide(1)->links() }} --}}
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!--end col-->
    </div>
    <!--end row-->
@endsection
