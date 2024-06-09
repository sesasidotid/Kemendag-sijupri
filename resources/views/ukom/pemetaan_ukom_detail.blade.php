@extends('layout.v_wrapper')
@section('title')
    Detail Ukom
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div class="flex-shrink-0 alert alert-primary">
                    Detail Ukom
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row text-dark mb-1">
                            <div class="col-3">Nama</div>
                            <div class="col">{{ $ukom->name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" active data-bs-toggle="tab" href="#nilai_ukom" role="tab"
                            aria-selected="true">
                            Nilai Ukom
                        </a>
                    </li>
                    @if ($ukom->ukomTeknis->is_lulus)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#rekomendasi" role="tab"
                                aria-selected="false">
                                Rekomendasi
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="nilai_ukom" role="tabpanel">
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Periode</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ date('F Y', strtotime($ukom->ukomPeriode->periode)) }}">
                            </div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai CAT</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->cat }}">
                            </div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai Wawancara</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->wawancara }}">
                            </div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai Seminar</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->seminar }}">
                            </div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai NB CAT</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->nb_cat }}">
                            </div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai NB Wawancara</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->nb_wawancara }}"></div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai NB Seminar</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->nb_seminar }}">
                            </div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai NB Praktik</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->nb_praktik }}">
                            </div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Total Nilai UKT</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->total_nilai_ukt }}"></div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai UKT</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->nilai_ukt }}">
                            </div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Total Nilai Kompetensi Manajerial</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomMansoskul->jpm }}"></div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">UKMSK</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->ukmsk }}"></div>
                        </div>
                        <div class="row text-dark mb-1">
                            <div class="col-4"><label for="">Nilai Akhir</label></div>
                            <div class="col"><input type="text" class="form-control" readonly
                                    value="{{ $ukom->ukomTeknis->nilai_akhir }}"></div>
                        </div>
                    </div>
                    @if ($ukom->ukomTeknis->is_lulus)
                        <div class="tab-pane" id="rekomendasi" role="tabpanel">
                            <div class="card shadow-sm p-2">
                                <div class="card-body">
                                    <form method="POST"
                                        action="{{ route('/ukom/upload_rekomendasi', ['id' => $ukom->id]) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="FileRekomendasi" class="form-label">
                                                        <span class="text-danger fw-bold">*</span>
                                                        File Rekomendasi
                                                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                                    </label>
                                                    <input name="file_rekomendasi" type="file" accept=".pdf"
                                                        class="form-control" id="FileRekomendasi" />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary btn-sm float-end m-1">
                                                    Upload
                                                </button>
                                            </div>
                                            @if (isset($ukom->file_rekomendasi) && $ukom->file_rekomendasi)
                                                <hr>
                                                <div class="col-12">
                                                    <iframe id="previewIframe" width="100%" height="600px"
                                                        src="{{ asset($ukom->file_rekomendasi ? 'storage/' . $ukom->file_rekomendasi : 'rekomendasi') }}">
                                                    </iframe>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                    @include('widget.modal-doc')
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
