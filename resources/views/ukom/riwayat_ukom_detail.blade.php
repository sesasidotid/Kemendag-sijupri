@extends('layout.v_wrapper')
@section('title')
    Detail Ukom
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Detail Ukom
                    @if ($ukom->ukomTeknis->is_lulus)
                        <a class="btn btn-sm btn-success float-end" href="javascript:void(0);"
                            onclick="previewModal({{ json_encode($ukom->file_rekomendasi) }}, 'Rekomendasi Ukom')">
                            Cetak Rekomendasi
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Ukom Periode</label></div>
                    <div class="col"><input type="text" class="form-control" readonly
                            value="{{ date('F Y', strtotime($ukom->ukomPeriode->periode)) }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai CAT</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomTeknis->cat }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai Wawancara</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomTeknis->wawancara }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai Seminar</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomTeknis->seminar }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai NB CAT</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomTeknis->nb_cat }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai NB Wawancara</label></div>
                    <div class="col"><input type="text" class="form-control" readonly
                            value="{{ $ukom->ukomTeknis->nb_wawancara }}"></div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai NB Seminar</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomTeknis->nb_seminar }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai NB Praktik</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomTeknis->nb_praktik }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Total Nilai UKT</label></div>
                    <div class="col"><input type="text" class="form-control" readonly
                            value="{{ $ukom->ukomTeknis->total_nilai_ukt }}"></div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai UKT</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomTeknis->nilai_ukt }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Total Nilai Kompetensi Manajerial</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomMansoskul->jpm }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">UKMSK</label></div>
                    <div class="col"><input type="text" class="form-control" readonly value="{{ $ukom->ukomTeknis->ukmsk }}">
                    </div>
                </div>
                <div class="row text-dark mb-1">
                    <div class="col-4"><label for="">Nilai Akhir</label></div>
                    <div class="col"><input type="text" class="form-control" readonly
                            value="{{ $ukom->ukomTeknis->nilai_akhir }}"></div>
                </div>
            </div>
        </div>
        @include('widget.modal-doc')
    </div>
@endsection
