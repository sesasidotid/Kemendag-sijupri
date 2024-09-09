@extends('layout.master-without-nav')
@section('title')
    Landing
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    @include('layout.css_select')
@endsection
@section('content')
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top bg-white" id="navbar">
        <div class="container">
            <a href="#" class="logo logo-dark ">
                <span class="logo-sm">
                    <img src="{{ asset('images/kemendag-320-bg.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('images/kemendag-768-bg.png') }}" alt="" height="40">
                </span>
            </a>
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('images/kemendag-320.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('images/kemendag-768.png') }}" alt="" height="40">
                </span>
            </a>
            <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="w-100">
                    <ul class="navbar-nav mt-2 mt-lg-0 float-end" id="navbar-example">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('/') }}">Landing</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-soft-primary mt-2" href="{{ route('login') }}">Masuk</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="vertical-overlay" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent.show"></div>
    <section class="section pb-5 hero-section mt-5" id="hero">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Detail Pendaftaran Ukom
                    @if (isset($ukom->ukomTeknis->is_lulus) && $ukom->ukomTeknis->is_lulus)
                        <a class="btn btn-sm btn-success float-end" href="javascript:void(0);"
                            onclick="previewModal({{ json_encode($ukom->file_rekomendasi) }}, 'Rekomendasi Ukom')">
                            Cetak Rekomendasi
                        </a>
                    @endif
                </div>
            </div>
            @if (isset($ukom) && $ukom != null)
                <div class="row card-body">
                    <div class="col-4">
                        <img src="{{ asset('storage/' . $file_qrcode) }}" alt="">
                        <br>
                        <span class="text-secondary float-end" style="font-size: 10px">
                            (mohon di unduh apabila file tidak terunduh otomatis)
                        </span>
                        <br>
                        <a id="qr-download" href="{{ asset('storage/' . $file_qrcode) }}" download="qr_code.png"
                            class="btn btn-sm btn-soft-secondary float-end">unduh gambar</a>
                    </div>
                    <div class="col-7">
                        @include('widget.timeline', ['timelineList' => $ukom->auditTimeline])
                    </div>
                </div>
            @endif
        </div>
        <div class="container card">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0 flex-nowrap mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#detail_pendaftaran" role="tab">
                            <i class=" las la-user-graduate"></i>
                            Detail Pendaftaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#hasil_ukom" role="tab">
                            <i class=" las la-sort-up"></i>
                            Hasil UKom
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="detail_pendaftaran" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row text-dark">
                                    <div class="col-3">Periode</div>
                                    <div class="col">
                                        {{ date('F Y', strtotime($ukom->ukomPeriode->periode)) }}</div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">Nama</div>
                                    <div class="col">{{ $ukom->name }}</div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">Tempat, Tanggal Lahir</div>
                                    <div class="col">
                                        {{ $ukom->detail->tempat_lahir ?? '' }},
                                        {{ substr($ukom->detail->tanggal_lahir ?? '', 0, 10) }}
                                    </div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">Jenis Kelamin</div>
                                    <div class="col">{{ $ukom->detail->jenis_kelamin ?? '' }}</div>
                                </div>
                                @if (isset($ukom->detail->karpeg) && $ukom->detail->karpeg != null)
                                    <div class="row text-dark">
                                        <div class="col-3">Nomor Kartu Pegawai</div>
                                        <div class="col">{{ $ukom->detail->karpeg ?? '' }}
                                        </div>
                                    </div>
                                @endif
                                @if (isset($ukom->detail->tmt_cpns) && $ukom->detail->tmt_cpns != null)
                                    <div class="row text-dark">
                                        <div class="col-3">TMT CPNS</div>
                                        <div class="col">{{ $ukom->detail->tmt_cpns ?? '' }}
                                        </div>
                                    </div>
                                @endif
                                <div class="row text-dark">
                                    <div class="col-3">Jabatan</div>
                                    <div class="col">{{ $ukom->detail->jabatan_name ?? '' }}
                                    </div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">Jenjang</div>
                                    <div class="col">{{ $ukom->detail->jenjang_name ?? '' }}
                                    </div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">TMT Jabatan</div>
                                    <div class="col">{{ $ukom->detail->tmt_jabatan ?? '' }}
                                    </div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">Pangkat</div>
                                    <div class="col">{{ $ukom->detail->pangkat_name ?? '' }}
                                    </div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">TMT Pangkat</div>
                                    <div class="col">{{ $ukom->detail->tmt_pangkat ?? '' }}
                                    </div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">Unit Kerja</div>
                                    <div class="col">{{ $ukom->detail->unit_kerja_name ?? '' }}</div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">Alamat Unit Kerja</div>
                                    <div class="col">{{ $ukom->detail->unit_kerja_alamat ?? '' }}</div>
                                </div>
                                <hr>
                                <div class="row text-dark">
                                    <div class="col-3">Jabatan Tujuan</div>
                                    <div class="col">{{ $ukom->detail->tujuan_jabatan_name ?? '' }}</div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">Jenjang Tujuan</div>
                                    <div class="col">{{ $ukom->detail->tujuan_jenjang_name ?? '' }}</div>
                                </div>
                                <div class="row text-dark">
                                    <div class="col-3">pangkat Tujuan</div>
                                    <div class="col">{{ $ukom->detail->tujuan_pangkat_name ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="hasil_ukom" role="tabpanel">
                        @if (isset($ukom->ukomTeknis) && $ukom->ukomTeknis)
                            <div class="row text-dark mb-1">
                                <div class="col-4"><label for="">Ukom Periode</label></div>
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
                                        value="{{ $ukom->ukomMansoskul->jpm }}">
                                </div>
                            </div>
                            <div class="row text-dark mb-1">
                                <div class="col-4"><label for="">UKMSK</label></div>
                                <div class="col"><input type="text" class="form-control" readonly
                                        value="{{ $ukom->ukomTeknis->ukmsk }}">
                                </div>
                            </div>
                            <div class="row text-dark mb-1">
                                <div class="col-4"><label for="">Nilai Akhir</label></div>
                                <div class="col"><input type="text" class="form-control" readonly
                                        value="{{ $ukom->ukomTeknis->nilai_akhir }}"></div>
                            </div>
                        @else
                            <div class="flex-shrink-0 alert alert-secondary w-100">
                                Hasil UKom belum diterbitkan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if ($ukom->task_status == 'REJECT')
            <div class="container card">
                <div class="card-header">
                    <div class="text-center w-100">
                        <h3 class="mb-3 fw-semibold mb-5">Dokumen Perbaikan</h3>
                    </div>
                </div>
                <form method="POST" action="{{ route('/page/ukom/pendaftaran_ukom/perbaikan', ['id' => $ukom->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @foreach ($ukom->storage as $index => $storage)
                        @if ($storage->task_status !== 'APPROVE')
                            <div class="col-md-12 mb-3">
                                <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i>
                                    {{ $storage->name }}
                                    <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                </label>
                                <input type="file" accept=".pdf"
                                    class="form-control @error('storage[{{ $storage->id }}]') is-invalid @enderror"
                                    name="storage[{{ $storage->id }}]" id="employeeName"
                                    value="{{ old('storage[' . $storage->id . ']') }}">
                                @error('storage[{{ $storage->id }}]')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                    @endforeach
                    <div>
                        <button type="submit" class="btn btn-primary float-end mb-3">
                            Kirim <i class=" las la-save"></i>
                        </button>
                    </div>
                </form>
            </div>
        @endif
        @include('widget.modal-doc')
    </section>
@endsection
@section('script')
    @include('layout.js_select')
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/landing.init.js') }}"></script>
    <script>
        function limitLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
        },
        function validateLength(input) {
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);
            }
        }
    </script>
    @if (!$isDownloaded)
        <script>
            var link = document.getElementById('qr-download');
            link.click();
        </script>
    @endif
@endsection
