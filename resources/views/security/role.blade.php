@extends('layout.v_wrapper')
@section('title')
    Role Admin SIjuPRI
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
            </div>
            <div class="card-body">
                <table class="main-table table table-nowrap table-striped-columns mb-0 w-100">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Code</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($roleList))
                            @foreach ($roleList as $index => $value)
                                <tr>
                                    <td scope="col">{{ $index + 1 }}</td>
                                    <td scope="col">{{ $value->code }}</td>
                                    <td scope="col">{{ $value->name }}</td>
                                    <td scope="col">
                                        <a class="btn btn-sm btn-soft-primary" href="{{ route('/security/role/detail', $value->code) }}">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
