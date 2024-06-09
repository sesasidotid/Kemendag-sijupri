@extends('layout.v_wrapper')
@section('title')
    Daftar Request Formasi
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="row">
        <div class="card" id="applicationList">
            <div class="col-xxl-6">
                <div class="card-body">
                    <div>
                        <table class="main-table table table-bordered nowrap align-middle w-100">
                            <thead class="bg-light  ">
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja/Instansi Daerah</th>
                                    <th>Formasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($formasiList))
                                    @foreach ($formasiList as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->unitKerja->name }}</td>
                                            <td>{{ $item->jabatan->name }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('/formasi/request_formasi/proses_verifikasi_dokumen', $item->id) }}"
                                                        class="btn btn-sm btn-soft-info">
                                                        Proses Verifikasi
                                                    </a>
                                                    @if ($item->waktu_pelaksanaan))
                                                        <a href="{{ route('/formasi/request_formasi/detail', $item->id) }}"
                                                            class="btn btn-sm btn-soft-primary">
                                                            Detail
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card-body -->
            </div><!--end col-->
        </div><!--end row-->
    </div>
    <!--end row-->
@endsection
