@extends('layout.v_wrapper')
@section('title')
    Pengajuan Formasi
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
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" active data-bs-toggle="tab" href="#unsur" role="tab"
                            aria-selected="true">
                            Unsur
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#rekapitulasi" role="tab" aria-selected="false">
                            Rekapitulasi
                        </a>
                    </li>
                </ul>
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="unsur" role="tabpanel">
                        @livewire('formasi.formasi-perhitungan', ['jabatan_code' => $jabatan_code])
                    </div>
                    <div class="tab-pane" id="rekapitulasi" role="tabpanel">
                        @livewire('formasi.formasi-rekapitulasi', ['jabatan_code' => $jabatan_code])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
