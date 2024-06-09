@extends('layout.v_wrapper')
@section('title')
    Data Kabupaten
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
                <div class="row">
                    <form method="POST" action="{{ route('/maintenance/kabupaten/store') }}" class="mb-3">
                        @csrf
                        <!-- Basic Input -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="Provinsi" class="form-label">
                                    Provinsi
                                </label>
                                <div class="col-lg-12">
                                    <select class="form-select mb-3" name="provinsi_id" aria-label="Provinsi"
                                        id="Provinsi">
                                        <option selected>Pilih Provinsi</option>
                                        @if (isset($provinsiList))
                                            @foreach ($provinsiList as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
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
                                <th scope="col">Provinsi</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($kabupatenList))
                                @foreach ($kabupatenList as $index => $kabupaten)
                                    <tr>
                                        <td scope="col">{{ $index + 1 }}</td>
                                        <td scope="col">{{ $kabupaten->name }}</td>
                                        <td scope="col">{{ $kabupaten->provinsi->name }}</td>
                                        <td scope="col" class="text-center">
                                            <a href="{{ route('/maintenance/kabupaten/detail', ['id' => $kabupaten->id]) }}"
                                                class="btn btn-sm btn-soft-primary">
                                                Detail
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
    </div>
    <!--end row-->
@endsection
