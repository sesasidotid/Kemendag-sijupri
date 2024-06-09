@extends('layout.v_wrapper')
@section('title')
    Import Nilai UKom
@endsection
@push('ext_header')
    @include('layout.css_select')
@endpush
@push('ext_footer')
    @include('layout.js_select')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Import Nilai UKom Pada Periode Tertentu
                    <div class="float-end">
                        <form class="float-end" method="POST" action="{{ route('/ukom/import_nilai/template_teknis') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Template Teknis</button>
                        </form>
                        <form class="float-end" method="POST"
                            action="{{ route('/ukom/import_nilai/template_mansoskul') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm me-2">Template Mansoskul</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('/ukom/import_nilai/store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex-shrink-0 alert alert-white">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="">Periode UKom</label>
                                <select class="js-example-basic-single @error('ukom_periode_id') is-invalid @enderror"
                                    name="ukom_periode_id">
                                    <option value="">Pilih Periode</option>
                                    @if (isset($ukomPeriodeList))
                                        @foreach ($ukomPeriodeList as $index => $ukomPeriode)
                                            <option value="{{ $ukomPeriode->id }}"
                                                {{ request('ukom_periode_id') == $ukomPeriode->id ? 'selected' : '' }}>
                                                {{ date('F Y', strtotime($ukomPeriode->periode)) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="">Nilai Mansoskul
                                    <strong class="text-info">(file: Excel)</strong>
                                </label>
                                <input name="file_mansoskul" type="file" accept=".xls, .xlsx"
                                    class="form-control border-bottom-1" id="mansoskul" />
                            </div>
                            <div class="col-12 mb-2">
                                <label for="">Nilai Teknis
                                    <strong class="text-info">(file: Excel)</strong>
                                </label>
                                <input name="file_teknis" type="file" accept=".xls, .xlsx"
                                    class="form-control  border-bottom-1" id="mansoskul" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-success float-end">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
