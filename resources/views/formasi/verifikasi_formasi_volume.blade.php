@extends('layout.v_wrapper')
@section('title')
    Verifikasi Formasi
@endsection
@push('ext_header')
    @include('layout.css_tables')
    <link href="{{ asset('starter/float/dist/mfb.css') }}" rel="stylesheet">
    <script src="{{ asset('starter/float/src/mfb.js') }}"></script>
@endpush
@push('ext_footer')
    @include('layout.tables_s')
    <link rel="stylesheet" href="{{ asset('auth/ef.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="card" id="applicationList">
            <div class="card-header bg-light border-0">
                <h5 class="card-title mb-md-0 flex-grow-1">
                    Unit Kerja/Instansi Daerah {{ $formasi->unitKerja->name }} ({{ $formasi->unitKerja->operasional }})
                </h5>
            </div>
            <div class="card-body justify-content-start d-print-none">
                @if (isset($formasi->unitKerja->instansi->provinsi))
                    <div class="hstack gap-2">
                        <div style="width: 10%">Provinsi</div>
                        <div>:</div>
                        <div>{{ $formasi->unitKerja->instansi->provinsi->name }}</div>
                    </div>
                @endif
                @if (isset($formasi->unitKerja->instansi->kabupaten))
                    <div class="hstack gap-2 mt-2">
                        <div style="width: 10%">Kabupaten</div>
                        <div>:</div>
                        <div>{{ $formasi->unitKerja->instansi->kabupaten->name }}</div>
                    </div>
                @endif
                @if (isset($formasi->unitKerja->instansi->kota))
                    <div class="hstack gap-2 mt-2">
                        <div style="width: 10%">Kota</div>
                        <div>:</div>
                        <div>{{ $formasi->unitKerja->instansi->kota->name }}</div>
                    </div>
                @endif
                <div class="hstack gap-2 mt-2">
                    <div style="width: 10%">Email</div>
                    <div>:</div>
                    <div>{{ $formasi->unitKerja->email ?? '-' }}</div>
                </div>
                <div class="hstack gap-2 mt-2">
                    <div style="width: 10%">Nomor Telephone</div>
                    <div>:</div>
                    <div>{{ $formasi->unitKerja->phone ?? '-' }}</div>
                </div>
                <div class="hstack gap-2 mt-2">
                    <div style="width: 10%">Alamat</div>
                    <div>:</div>
                    <div>{{ $formasi->unitKerja->alamat ?? '-' }}</div>
                </div>
            </div>
        </div>
        <div class="card" id="applicationList">
            <div class="card-header bg-light border-0">
                <h5 class="card-title mb-md-0 flex-grow-1">
                    Data Formasi
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="text-center text-dark h6 col">Unsur</div>
                    <div class="text-center text-dark h6 col-2">Volume <br> (Inputan Pertahun)</div>
                    <div class="text-center text-dark h6 col-1">Jenjang</div>
                </div>
                <hr class="bg-dark">
                @php $formasiData = $formasi; @endphp
                @include('formasi._unsur', [
                    'child' => $formasiUnsurList,
                ])
                <ul id="menu" class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
                    <li class="mfb-component__wrap">
                        <div class="btn-group " role="group" aria-label="Basic example">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <a href="{{ route('/formasi/request_formasi/detail_formasi', ['id' => $formasi->id]) }}"
                                        class="btn btn-sm btn-soft-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                @include('widget.modal-doc')
            </div>
        </div>
    </div>
@endsection
