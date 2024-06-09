@extends('layout.v_wrapper')
@section('title')
    Pertanyaan KKN
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('/akp/kkn/pertanyaan/edit', ['id' => $akpPertanyaan->id]) }}"
                    class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="Pertanyaan" class="form-label">
                                Pertanyaan
                            </label>
                            <input type="text" name="pertanyaan"
                                class="form-control @error('pertanyaan') is-invalid @enderror" id="Pertanyaan"
                                placeholder="Masukkan Pertanyaan" value="{{ $akpPertanyaan->pertanyaan }}">
                            @error('Pertanyaan')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary float-end">
                                Ubah <i class=" las la-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
