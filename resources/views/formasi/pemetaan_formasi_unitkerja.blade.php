@extends('layout.v_wrapper')
@section('title')
    Pemetaan Formasi
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <form method="GET" action="">
            <div class="card">
                <div class="card-body">
                    <div class="flex-shrink-0 alert alert-primary">
                        Pemetaan Formasi (Unit Kerja/Instansi Daerah)
                    </div>
                    <div class="d-flex w-100">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="main-table table table-bordered nowrap align-middle w-100">
                        <thead>
                            <tr class="font-12">
                                <th>No</th>
                                <th>Unit Kerja/Instansi Daerah </th>
                                <th class="text-center">Formasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unitKerjaList as $index => $unitKerja)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $unitKerja->name }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-soft-primary" data-bs-toggle="collapse"
                                            href="#formasi_{{ $unitKerja->id }}" role="button" aria-expanded="false"
                                            aria-controls="formasi_{{ $unitKerja->id }}"> Show
                                        </a>
                                    </td>
                                </tr>
                                <tr class="collapse" id="formasi_{{ $unitKerja->id }}">
                                    <td colspan="3">
                                        <div class="card card-body">
                                            <table class="table table-striped ms-3 p-0">
                                                <thead class=" p-0">
                                                    <tr class="font-12 p-0">
                                                        <th class="p-0">No</th>
                                                        <th class="p-0">Jabatan </th>
                                                        <th class="text-center p-0">pemula</th>
                                                        <th class="text-center p-0">terampil</th>
                                                        <th class="text-center p-0">mahir</th>
                                                        <th class="text-center p-0">penyelia</th>
                                                        <th class="text-center p-0">pertama</th>
                                                        <th class="text-center p-0">muda</th>
                                                        <th class="text-center p-0">madya</th>
                                                        <th class="text-center p-0">utama</th>
                                                    </tr>
                                                </thead>
                                                <tbody class=" p-0">
                                                    @foreach ($unitKerja->formasiList() as $index => $item)
                                                        <tr class="font-12 p-0">
                                                            <td class="p-0">{{ $index + 1 }}</td>
                                                            <td class="p-0">{{ $item->jabatan }}</td>
                                                            <td class="text-center p-0">{{ $item->pemula_sum ?? 0 }}</td>
                                                            <td class="text-center p-0">{{ $item->terampil_sum ?? 0 }}</td>
                                                            <td class="text-center p-0">{{ $item->mahir_sum ?? 0 }}</td>
                                                            <td class="text-center p-0">{{ $item->penyelia_sum ?? 0 }}
                                                            </td>
                                                            <td class="text-center p-0">{{ $item->pertama_sum ?? 0 }}</td>
                                                            <td class="text-center p-0">{{ $item->muda_sum ?? 0 }}</td>
                                                            <td class="text-center p-0">{{ $item->madya_sum ?? 0 }}</td>
                                                            <td class="text-center p-0">{{ $item->utama_sum ?? 0 }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection
