@extends('layout.v_wrapper')
@section('title')
    Daftar Request Formasi
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
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Daftar Unit Kerja/Instansi Daerah Yang Me-Request Formasi
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="row text-dark">
                            <div class="col-3"><b>Unit Kerja/Instansi Daerah</b></div>
                            <div class="col"><b>{{ $unitKerja->name ?? '-' }}</b></div>
                        </div>
                        <hr>
                        @if ($unitKerja->instansi->provinsi_id)
                            <div class="row text-dark">
                                <div class="col-3">Provinsi</div>
                                <div class="col">{{ $unitKerja->instansi->provinsi->name ?? '-' }}</div>
                            </div>
                        @endif
                        @if ($unitKerja->instansi->kabupaten_id)
                            <div class="row text-dark">
                                <div class="col-3">Provinsi</div>
                                <div class="col">{{ $unitKerja->instansi->kabupaten->name ?? '-' }}</div>
                            </div>
                        @endif
                        @if ($unitKerja->instansi->kota_id)
                            <div class="row text-dark">
                                <div class="col-3">Provinsi</div>
                                <div class="col">{{ $unitKerja->instansi->kota->name ?? '-' }}</div>
                            </div>
                        @endif
                        <div class="row text-dark">
                            <div class="col-3">Alamat</div>
                            <div class="col">{{ $unitKerja->alamat ?? '-' }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Email</div>
                            <div class="col">{{ $unitKerja->email ?? '-' }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Nomor Telepon</div>
                            <div class="col">{{ $unitKerja->phone ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if ($formasiDokument->waktu_pelaksanaan == null)
                    <div class="row">
                        <form
                            action="{{ route('/formasi/request_formasi/proses_verifikasi_dokumen/store', ['id' => $formasiDokument->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-12">
                                <table>
                                    @foreach ($formasiDokument->storage as $index => $storage)
                                        <tr>
                                            <td class="pe-2">
                                                <label for="" class="form-label">
                                                    {{ $storage->name }}
                                                </label>
                                            </td>
                                            <td class="pe-2">
                                                : <a class="btn btn-sm btn-soft-info" href="javascript:void(0);"
                                                    onclick="previewModal({{ json_encode($storage->file) }}, {{ json_encode($storage->name) }})">
                                                    Lihat <i class=" las la-eye"></i>
                                                </a>
                                            </td>
                                            <td class="pe-2">
                                                <div class="btn-group">
                                                    <div>
                                                        <input type="radio" class="btn-sm btn-check"
                                                            name="storage[{{ $storage->id }}}[task_status]"
                                                            id="terima_{{ $index }}" autocomplete="off" checked
                                                            value="APPROVE">
                                                        <label class="btn btn-sm btn-outline-success"
                                                            for="terima_{{ $index }}">
                                                            Terima
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" class="btn-sm btn-check"
                                                            name="storage[{{ $storage->id }}}[task_status]"
                                                            id="tolak_{{ $index }}" autocomplete="off"
                                                            value="REJECT">
                                                        <label class="btn btn-sm btn-outline-danger"
                                                            for="tolak_{{ $index }}">
                                                            Tolak
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
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
                                    <input name="file_surat_undangan" type="file" accept=".pdf" class="form-control">
                                </div>
                            </div>
                            <div>
                                <div class="btn-group float-end">
                                    <button type="submit" class="btn btn-sm btn-soft-danger" name="task_status"
                                        value="REJECT">
                                        Tolak
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-soft-success" name="task_status"
                                        value="APPROVE">
                                        Terima
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <script>
                        const formasiIds = [];
                    </script>
                    <form method="POST"
                        action="{{ route('/formasi/request_formasi/verifikasi', ['id' => $formasiDokument->id]) }}">
                        @csrf
                        <table class="main-table">
                            <thead>
                                <tr class="text-center font-12">
                                    <th>No</th>
                                    <th class="text-center">Nama Jabatan </th>
                                    <th class="text-center">Jenjang Jabatan</th>
                                    <th class="text-center">Rekapitulasi Usulan Formasi</th>
                                    <th class="text-center">Rekomendasi Formasi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($formasiList as $indexP => $formasi)
                                    <script>
                                        formasiIds.push('{{ $formasi->id }}');
                                    </script>
                                    @php
                                        $formasiResult = $formasi->formasiResult;
                                        $size = count($formasiResult);
                                    @endphp
                                    @if ($formasiResult->isNotEmpty())
                                        @foreach ($formasiResult as $index => $item)
                                            <tr>
                                                @if ($index == 0)
                                                    <td class="m-0 p-0" rowspan="{{ $size + 1 }}">
                                                        {{ $indexP + 1 }}
                                                    </td>
                                                    <td class="m-0 p-0" rowspan="{{ $size }}">
                                                        {{ $formasi->jabatan->name }}
                                                    </td>
                                                @endif
                                                <td class="m-0 p-0 text-dark text-start fw-normal">
                                                    {{ $item->jenjang->name }}</td>
                                                <td>{{ $item->pembulatan }}</td>
                                                <td class="m-0 p-0">
                                                    <input type="number"
                                                        class="form-control value-result{{ $formasi->id }}"
                                                        name="{{ $formasi->jabatan_code }}[{{ $item->jenjang_code }}]">
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-start text-dark fw-bold" colspan="2">Jumlah Usulan Formasi
                                            </td>
                                            <td class="text-dark fw-bold">{{ $formasi->total }}</td>
                                            <td class="text-dark fw-bold">
                                                <span id="total-result{{ $formasi->id }}">0</span>
                                                <div class="btn-group float-end mb-3">
                                                    <a href="{{ route('/formasi/request_formasi/detail_volumen', ['id' => $formasi->id]) }}"
                                                        class="btn btn-sm btn-soft-info">Lihat
                                                    </a>
                                                    <a class="btn btn-sm btn-soft-primary">Unduh</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="bg-dark p-0"></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-sm btn-soft-success float-end">Terima</button>
                    </form>
                @endif
                {{-- <table class="main-table table table-bordered nowrap align-middle w-100">
                    <thead class="bg-light  ">
                        <tr>
                            <th>No</th>
                            <th>Formasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($formasiList))
                            @foreach ($formasiList as $index => $formasi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $formasi->jabatan->name }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('/formasi/request_formasi/proses_verifikasi_dokumen', $formasi->id) }}"
                                                class="btn btn-sm btn-soft-info">
                                                Proses Verifikasi
                                            </a>
                                            @if ($formasi->waktu_pelaksanaan)
                                                <a href="{{ route('/formasi/request_formasi/detail_formasi', $formasi->id) }}"
                                                    class="btn btn-sm btn-soft-primary">
                                                    Detail
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table> --}}
                @include('widget.modal-doc')
            </div>
        </div>
    </div>
@endsection
@push('ext_footer')
    <script>
        function calculateTotal() {
            formasiIds.forEach(formasiId => {
                const inputs = document.querySelectorAll('.value-result' + formasiId);
                let total = 0;

                inputs.forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('total-result' + formasiId).textContent = total;
            });
        }
        window.addEventListener('load', calculateTotal);
        document.addEventListener('input', calculateTotal);
    </script>
@endpush
