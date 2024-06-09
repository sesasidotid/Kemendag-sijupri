@extends('layout.v_wrapper')
@section('title')
    Verifikasi Formasi
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.tables_s')
@endpush
@section('content')
    <div class="row">
        <div class="card" id="applicationList">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Unit Kerja/Instansi Daerah : {{ $formasi->unitKerja->name }}
                </div>
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
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Data Formasi
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('/formasi/request_formasi/verifikasi', ['id' => $formasi->id]) }}">
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
                            @php
                                $formasiResult = $formasi->formasiResult;
                                $size = count($formasiResult);
                            @endphp
                            @if ($formasiResult->isNotEmpty())
                                @foreach ($formasiResult as $index => $item)
                                    <tr>
                                        @if ($index == 0)
                                            <td class="m-0 p-0" rowspan="{{ $size }}">1</td>
                                            <td class="m-0 p-0" rowspan="{{ $size }}">{{ $formasi->jabatan->name }}
                                            </td>
                                        @endif
                                        <td class="m-0 p-0 text-dark fw-normal">{{ $formasi->jabatan->name }} Ahli
                                            {{ $item->jenjang->name }}</td>
                                        <td>{{ $item->pembulatan }}</td>
                                        <td class="m-0 p-0">
                                            <input type="number" class="form-control value-result"
                                                name="{{ $item->jenjang_code }}">
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-start text-dark fw-bold" colspan="3">Jumlah Usulan Formasi</td>
                                    <td class="text-dark fw-bold">{{ $formasi->total }}</td>
                                    <td class="text-dark fw-bold">
                                        <span id="total-result">{{ $formasi->total }}</span>
                                        <button type="submit"
                                            class="btn btn-sm btn-soft-success float-end">verifikasi</button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                <div class="btn-group float-end mb-3">
                    <a href="{{ route('/formasi/request_formasi/detail_volumen', ['id' => $formasi->id]) }}"
                        class="btn btn-sm btn-soft-info">Lihat
                    </a>
                    <button type="submit" class="btn btn-sm btn-soft-primary">Unduh</button>
                </div>
                @include('widget.modal-doc')
            </div>
        </div>
    </div>
@endsection
@push('ext_footer')
    <script>
        function calculateTotal() {
            const inputs = document.querySelectorAll('.value-result');
            let total = 0;

            inputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('total-result').textContent = total;
        }
        window.addEventListener('load', calculateTotal);
        document.addEventListener('input', calculateTotal);
    </script>
@endpush
