@extends('layout.v_wrapper')
@section('title')
    Data Rekomendasi AKP
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <form method="GET" action="">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <div class="flex-shrink-0 alert alert-primary w-100">
                        Rekomendasi AKP Instrument ({{ $akpInstrumen->name }})
                        <a class="btn btn-sm btn-success float-end" href="javascript:void(0);"
                            onclick="previewModal({{ json_encode($akp->file_rekomendasi) }}, 'Rekomendasi Formasi')">
                            Cetak Rekomendasi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="main-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Rekomendasi Pelatihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($akpMatrixList))
                                @foreach ($akpMatrixList as $index => $akpMatrix)
                                    @if ($akpMatrix->akpPelatihan)
                                        <tr>
                                            <td style="font-size: 0.9rem">{{ $index + 1 }}</td>
                                            <td style="font-size: 0.9rem">{{ $akpMatrix->akpPelatihan->name }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        @include('widget.modal-doc')
    </div>
@endsection
