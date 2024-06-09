@extends('layout.v_wrapper')
@section('title')
    Daftar Request Formasi
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
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Daftar Unit Kerja/Instansi Daerah Yang Me-Request Formasi
                </div>
            </div>
            <form method="GET" action="">
                <div class="row card-body">
                    <div class="col-3">
                        <label for="" class="m-0 p-0"><small>Nama Unit Kerja/Instansi Daerah</small></label>
                        <input type="text" class="form-control form-control-sm" name="attr[name]"
                            value="{{ request('attr.name') }}">
                    </div>
                </div>
                <div class="w-100">
                    <button type="submit" class="btn btn-sm btn-primary mb-3 ms-3">Cari</button>
                </div>
            </form>
        </div>
        <div class="card card-body">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit Kerja/Instansi Daerah</th>
                        <th>Provinsi</th>
                        <th>Kabupaten/Kota</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($unitKerjaList)
                        @foreach ($unitKerjaList as $index => $unitKerja)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $unitKerja->name }}</td>
                                <td>{{ $unitKerja->instansi->provinsi->name ?? '-' }}</td>
                                <td>{{ $unitKerja->instansi->kabupaten->name ?? ($unitKerja->instansi->kota->name ?? '-') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-soft-primary"
                                        href="{{ route('/formasi/request_formasi/detail', ['id' => $unitKerja->id]) }}">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $unitKerjaList->appends(request()->query())->onEachSide(1)->links() }}
            @include('widget.modal-doc')
        </div>
    </div>
@endsection
