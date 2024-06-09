@extends('layout.v_wrapper')
@section('title')
    Detail Soal KKN
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
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('/akp/kkn/edit', ['id' => $akpKategoriPertanyaan->id]) }}"
                    class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="Intrumen" class="form-label">
                                Intrumen
                            </label>
                            <div class="col-lg-12">
                                <select class="form-select mb-3 @error('akp_instrumen_id') is-invalid @enderror"
                                    aria-label="Intrumen" id="Intrumen" name="akp_instrumen_id">
                                    @if (isset($akpInstrumentList))
                                        @foreach ($akpInstrumentList as $akpInstrumen)
                                            <option value="{{ $akpInstrumen->id }}"
                                                @if ($akpInstrumen->id == $akpKategoriPertanyaan->instrumen_id) selected @endif>
                                                {{ $akpInstrumen->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('akp_instrumen_id')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="Kategori" class="form-label">
                                Kategori
                            </label>
                            <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                                name="kategori" id="Kategori" placeholder="Masukkan Kategori"
                                value="{{ $akpKategoriPertanyaan->kategori }}">
                            @error('kategori')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary float-end">
                            Ubah <i class=" las la-save"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
