@extends('layout.v_wrapper')
@section('title')
    Riwayat Rekomendasi
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
                    Daftar Riwayat Rekomendasi
                    @if ($unitKerja->statusRekomendasi())
                        <a class="btn btn-sm btn-primary float-end" href="javascript:void(0);"
                            onclick="previewModal({{ json_encode($unitKerja->file_rekomendasi_formasi) }}, 'Rekomendasi Formasi')">
                            Cetak Rekomendasi
                        </a>
                    @else
                        <a class="btn btn-sm btn-danger float-end" href="javascript:void(0);">
                            Menunggu Formasi
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu Terbit Rekomendasi</th>
                            <th>Status</th>
                            <th>Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($unitKerja->storage)
                            @foreach ($unitKerja->storage as $index => $storage)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $storage->created_at }}</td>
                                    <td>
                                        @if ($index == 0)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-soft-primary" href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($storage->file) }}, 'Rekomendasi')">
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @include('widget.modal-doc')
            </div>
        </div>
    </div>
@endsection
