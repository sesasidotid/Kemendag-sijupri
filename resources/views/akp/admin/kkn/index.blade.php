@extends('layout.v_wrapper')
@section('title')
    Daftar Soal KKN
@endsection
@push('ext_header')
    @include('layout.css_tables')
    @include('layout.css_select')
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 31px !important;
        }

        .select2-selection__arrow {
            height: 31px !important;
        }
    </style>
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.tables_s')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Form Tambah Kategori
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('/akp/kkn/store') }}" class="mb-3">
                    @csrf
                    <div class="col-lg-12 mb-3">
                        <label for="Instrumen" class="form-label">
                            Instrumen
                        </label>
                        <select class="js-example-basic-single mb-3" id="Instrumen" name="akp_instrumen_id">
                            <option selected value="">Pilih Instrumen</option>
                            @if (isset($akpInstrumentList))
                                @foreach ($akpInstrumentList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!--end col-->
                    <div class="col-lg-12 mb-3">
                        <label for="Kategori" class="form-label">
                            Kategori
                        </label>
                        <input type="text" class="form-control" name="kategori" id="Kategori"
                            placeholder="Masukkan Kategori">
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
                        <div class="col-12 alert alert-primary">
                            Daftar Kategori Pertanyaan
                        </div>
                        <div class="col-3">
                            <label class="m-0 p-0"><small>Kategori</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[kategori]"
                                value="{{ request('attr.kategori') }}">
                        </div>
                        <div class="col-3">
                            <label class="m-0 p-0">Instrumen</label>
                            <select class="js-example-basic-single" name="attr[akp_instrumen_id]">
                                <option value="">Pilih Instrumen</option>
                                @if (isset($akpInstrumentList))
                                    @foreach ($akpInstrumentList as $index => $provinsi)
                                        <option value="{{ $provinsi->id }}"
                                            {{ request('attr.akp_instrumen_id') == $provinsi->id ? 'selected' : '' }}>
                                            {{ $provinsi->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="w-100">
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Cari</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <div>
                    <table class="main-table  table table-bordered nowrap align-middle">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Instrumen</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($akpKategoriPertanyaanList))
                                @foreach ($akpKategoriPertanyaanList as $index => $kategori)
                                    <tr>
                                        <td scope="col">{{ $index + 1 }}</td>
                                        <td scope="col">{{ $kategori->kategori }}</td>
                                        <td scope="col">{{ $kategori->akpInstrumen->name }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('/akp/kkn/pertanyaan', ['akp_kategori_pertanyaan_id' => $kategori->id]) }}"
                                                    class="btn btn-sm btn-soft-primary">
                                                    Pertanyaan
                                                </a>
                                                <a href="{{ route('/akp/kkn/detail', ['id' => $kategori->id]) }}"
                                                    class="btn btn-sm btn-soft-info">
                                                    Ubah
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('/akp/kkn/delete', ['id' => $kategori->id]) }}">
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
                {{ $akpKategoriPertanyaanList->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
