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
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="col-12 flex-shrink-0 alert alert-primary w-100">
                    Form Tambah Pertanyaan
                </div>
            </div>
            <div class="card-body">
                <form method="POST"
                    action="{{ route('/akp/kkn/pertanyaan/store', ['akp_kategori_pertanyaan_id' => $akp_kategori_pertanyaan_id]) }}"
                    class="mb-3">
                    @csrf
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="Pertanyaan" class="form-label">
                                Pertanyaan
                            </label>
                            <input type="text" name="pertanyaan"
                                class="form-control @error('pertanyaan') is-invalid @enderror" id="Pertanyaan"
                                placeholder="Masukkan Pertanyaan">
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
                            <button type="submit" class="btn btn-sm btn-soft-success float-end">
                                Simpan <i class=" las la-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <form method="GET" action="">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 alert alert-primary w-100">
                            Pemetaan Jabatan Fungsional Pengguna AKP
                        </div>
                        <div class="col-3">
                            <label class="m-0 p-0"><small>Pertanyaan</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[pertanyaan]"
                                value="{{ request('attr.pertanyaan') }}">
                        </div>
                        <div class="w-100">
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Cari</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <div>
                    <table class="main-table display nowrap table table-bordered align-middle w-100">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Pertanyaan</th>
                                <th scope="col">Kategori</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($akpPertanyaanList))
                                @foreach ($akpPertanyaanList as $index => $pertanyaan)
                                    <tr>
                                        <td scope="col">{{ $index + 1 }}</td>
                                        <td scope="col">{{ $pertanyaan->pertanyaan }}</td>
                                        <td scope="col">{{ $pertanyaan->akpKategoriPertanyaan->kategori }}</td>
                                        <td scope="col" class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('/akp/kkn/pertanyaan/detail', ['id' => $pertanyaan->id]) }}"
                                                    class="btn btn-sm btn-soft-info">
                                                    Ubah
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('/akp/kkn/pertanyaan/delete', ['id' => $pertanyaan->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-soft-danger">
                                                        hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                {{-- {{ $akpPertanyaanList->appends(request()->query())->onEachSide(1)->links() }} --}}
            </div>
        </div>
    </div>
@endsection
