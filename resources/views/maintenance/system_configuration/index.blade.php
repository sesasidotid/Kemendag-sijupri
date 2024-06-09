@extends('layout.v_wrapper')
@section('title')
    Data Konfigurasi Sistem
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Daftar Konfigurasi Sistem
                </div>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="row">
                    <table class="main-table  table table-bordered nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($systemConfigurationList))
                                @foreach ($systemConfigurationList as $index => $systemConfiguration)
                                    <tr>
                                        <td scope="col">{{ $index + 1 }}</td>
                                        <td scope="col">{{ $systemConfiguration->name }}</td>
                                        <td scope="col" class="text-center">
                                            <a href="{{ route('/maintenance/konfigurasi/detail', ['code' => $systemConfiguration->code]) }}"
                                                class="btn btn-sm btn-soft-primary">
                                                Detail <i class="mdi mdi-circle-edit-outline text-primary"></i>
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
