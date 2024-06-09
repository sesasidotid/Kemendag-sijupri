@extends('layout.v_wrapper')
@section('title')
    Riwayat Aktivitas
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
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Tanggal Akses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($auditAktivitasList))
                                @foreach ($auditAktivitasList as $index => $auditAktivitas)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $auditAktivitas->nip }}</td>
                                        <td>{{ $auditAktivitas->name }}</td>
                                        <td>{{ $auditAktivitas->method }}</td>
                                        <td>{{ $auditAktivitas->ip_address }}</td>
                                        <td>{{ $auditAktivitas->user_agent }}</td>
                                        <td>{{ $auditAktivitas->tgl_access }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                {{ $auditAktivitasList->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
