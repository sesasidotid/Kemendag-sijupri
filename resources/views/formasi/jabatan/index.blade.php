@extends('layout.v_wrapper')
@section('title')
    Data Formasi
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.tables_s')
@endpush
@section('content')
    <div class="row">
        @if (count($formasiListInactive) !== 0)
            <div class="alert alert-primary" role="alert">
                <strong> Penetapan Formasi Awal </strong> Silahkan Konfirmasi Terlebih Dahulu
            </div>
            <hr>
        @endif
        @foreach ($formasiListInactive as $formasi)
            <form action="{{ route('/formasi/jabatan/konfirmasi') }}" method="post">
                <input type="text" hidden name="id" value="{{ $formasi->id }}">
                @csrf
                <div class="card" id="applicationList">
                    <div class="card-header">
                        <h4>Penetapan Formasi {{ ucfirst($formasi->jabatan->name) }}</h4>
                    </div>
                    <div class="col-xxl-6">
                        <div class="card-body">
                            <div>
                                <table class="main-table">
                                    <thead class="bg-light  ">
                                        <tr class="text-center font-12">
                                            <th>No</th>
                                            <th class="text-center">Nama Jabatan </th>
                                            <th class="text-center">Jenjang Jabatan</th>
                                            <th class="text-center">Penetapan Formasi Jabatan</th>
                                            <th class="text-center">Jumlah Usulan Formasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $formasiResult = $formasi->formasiResult;
                                            $size = count($formasiResult);
                                        @endphp
                                        @if ($formasiResult->isNotEmpty())
                                            @foreach ($formasiResult as $index => $item)
                                                <tr>
                                                    @if ($index == 0)
                                                        <td rowspan="{{ $size + 1 }}" class="p-0 m-0">1</td>
                                                        <td rowspan="{{ $size }}" class="p-0 m-0">
                                                            {{ ucfirst($formasi->jabatan->name) }}
                                                        </td>
                                                    @endif
                                                    <td class="p-0 m-0 text-dark fw-normal">
                                                        {{ ucfirst($item->jenjang->name) }}
                                                    </td>
                                                    <td class="text-center p-0 m-0">{{ $item->result ?? '0' }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2" class="text-dark">
                                                    Jumlah Formasi Yang Diusulkan
                                                </td>
                                                <td class="text-center text-dark fw-bold">{{ $formasi->total_result ?? '0' }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- end card-body -->
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            {{-- <button class="btn btn-danger btn-sm w-30">
                                Tolak
                            </button> --}}
                            <button class="btn btn-success btn-sm w-30" name="task_status" value="APPROVE">
                                Konfirmasi
                            </button>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </form>
        @endforeach
        @if (count($formasiList) === 0)
            <div class="alert alert-danger" role="alert">
                <strong> Belum Ada Data Fomasi, </strong> Mohon Menunggu...
            </div>
            <hr>
        @else
            <div class="alert alert-primary w-100" role="alert">
                <strong> Penetapan Formasi </strong>
                <a class="btn btn-sm btn-primary float-end ms-2"
                    href="{{ route('/formasi/data_rekomendasi_formasi/riwayat_rekomendasi') }}">
                    Cetak & Riwayat Rekomendasi
                </a>
            </div>
            <hr>
        @endif
        @foreach ($formasiList as $formasi)
            <div class="card" id="applicationList">
                <div class="card-header">
                    <label class="h4">Penetapan Formasi {{ ucfirst($formasi->jabatan->name) }}</label>
                </div>
                <div class="col-xxl-6">
                    <div class="card-body">
                        <div>
                            <table class="main-table">
                                <thead class="bg-light  ">
                                    <tr class="text-center font-12">
                                        <th class="p-0 m-0">No</th>
                                        <th class="text-center p-0 m-0">Nama Jabatan</th>
                                        <th class="text-center p-0 m-0">Jenjang Jabatan</th>
                                        <th class="text-center p-0 m-0">Penetapan Usulan Formasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $formasiResult = $formasi->formasiResult;
                                        $size = count($formasiResult);
                                    @endphp
                                    @if ($formasiResult->isNotEmpty())
                                        @foreach ($formasiResult as $index => $item)
                                            <tr>
                                                @if ($index == 0)
                                                    <td rowspan="{{ $size + 1 }}" class="p-0 m-0">1</td>
                                                    <td rowspan="{{ $size }}" class="p-0 m-0">
                                                        {{ ucfirst($formasi->jabatan->name) }}
                                                    </td>
                                                @endif
                                                <td class="p-0 m-0 text-dark fw-normal">
                                                    {{ ucfirst($item->jenjang->name) }}
                                                </td>
                                                <td class="text-center p-0 m-0">{{ $item->result ?? '0' }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="text-dark">
                                                Jumlah Formasi Yang Diusulkan
                                            </td>
                                            <td class="text-center text-dark fw-bold">{{ $formasi->total_result ?? '0' }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @include('widget.modal-doc')
                    </div><!-- end card-body -->
                </div><!--end col-->
            </div><!--end row-->
        @endforeach
    </div>
    <!--end row-->
@endsection
