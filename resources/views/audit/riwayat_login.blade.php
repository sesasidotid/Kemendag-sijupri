@extends('layout.v_wrapper')
@section('title')
    Riwayat Login
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
                <div>
                    <table class="main-table table table-bordered nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Tanggal Login</th>
                                <th>Tanggal Logout</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($auditLoginList))
                                @foreach ($auditLoginList as $index => $auditLogin)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $auditLogin->nip }}</td>
                                        <td>{{ $auditLogin->ip_address }}</td>
                                        <td>{{ $auditLogin->user_agent }}</td>
                                        <td>{{ $auditLogin->tgl_login }}</td>
                                        <td>{{ $auditLogin->tgl_logout }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                {{ $auditLoginList->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
