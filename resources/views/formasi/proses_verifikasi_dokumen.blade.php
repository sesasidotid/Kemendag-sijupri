@extends('layout.v_wrapper')
@section('title')
    Proses Verifikasi Dokumen Formasi
@endsection
@push('ext_header')
    @include('layout.css_select')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    <script>
        flatpickr("#dateInput", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header row align-items-center d-flex">
                <div class="col-12 flex-shrink-0 alert alert-primary w-100">
                    Penaftaran Periode UKom
                </div>
                <div class="col-12">
                    <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" active data-bs-toggle="tab" href="#dokumen" role="tab"
                                aria-selected="true">
                                Dokumen
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#riwayat" role="tab" aria-selected="false">
                                Riwayat
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content text-muted">
            <div class="tab-pane active" id="dokumen" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form
                                action="{{ route('/formasi/request_formasi/proses_verifikasi_dokumen/store', ['id' => $formasi->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3 gap-2">
                                    <div class="col-md-12 mb-2">
                                        <label for="" class="form-label">Waktu Pelaksanaan</label>
                                        <input type="datetime-local" name="waktu_pelaksanaan" class="form-control"
                                            value="{{ old('waktu_pelaksanaan') ?? ($formasi->waktu_pelaksanaan ?? '') }}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="" class="form-label">Surat Undangan
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <input name="file_surat_undangan" type="file" accept=".pdf"
                                            class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary float-end">
                                        Simpan <i class=" las la-save"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        @if ($formasi->file_surat_undangan)
                            <div class="row mt-2">
                                <hr>
                                <div class="col-12">
                                    <iframe id="previewIframe" width="100%" height="600px"
                                        src="{{ asset($formasi->file_surat_undangan ? 'storage/' . $formasi->file_surat_undangan : 'rekomendasi') }}">
                                    </iframe>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="riwayat" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <table class="main-table table table-nowrap table-striped-columns mb-0 w-100">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">tanggal eksekusi</th>
                                    {{-- <th scope="col">dieksekusi oleh</th> --}}
                                    <th scope="col">deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($formasi->auditTimeline))
                                    @foreach ($formasi->auditTimeline as $index => $timeline)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ date('Y-m-d', strtotime($timeline->created_at)) }}</td>
                                            {{-- <td>{{ $timeline->nip }}</td> --}}
                                            <td>{{ $timeline->description }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('widget.modal-doc')
        </div>
    </div>
@endsection
