@extends('layout.v_wrapper')
@section('title')
    Data Formasi
@endsection
@section('content')
    <div class="row">
        @if ($formasiData !== null)
            <div class="flex-shrink-0 alert alert-primary">
                <strong> Hi! </strong>Di bawah ini merupakan daftar <b>AKP</b>
            </div>
            <div class="card" id="applicationList">
                <div class="card-header">
                    <h4>Penetapan Formasi {{ ucfirst($formasiData->jabatan->name) }}</h4>
                </div>
                <div class="col-xxl-6">
                    <div class="card-body">
                        <div>
                            <table id="scroll-horizontal" class="table table-bordered nowrap align-middle w-100">
                                <thead class="bg-light  ">
                                    <tr class="text-center font-12">
                                        <th>No</th>
                                        <th class="text-center">Nama Jabatan </th>
                                        <th class="text-center">Jenjang Jabatan</th>
                                        <th class="text-center">Penetapan Usulan Formasi</th>
                                        <th class="text-center">Jumlah Formasi Yang Diusulkan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $formasiResult = $formasiData->formasiResult;
                                        $size = count($formasiResult);
                                    @endphp
                                    @if ($formasiResult->isNotEmpty())
                                        @foreach ($formasiResult as $index => $item)
                                            <tr>
                                                @if ($index == 0)
                                                    <td rowspan="{{ $size }}">1</td>
                                                    <td rowspan="{{ $size }}">
                                                        {{ ucfirst($formasiData->jabatan->name) }}
                                                    </td>
                                                @endif
                                                <td>
                                                    {{ ucfirst($formasiData->jabatan->name) }}
                                                    {{ ucfirst($item->jenjang->name) }}
                                                </td>
                                                <td class="text-center">{{ $item->pembulatan }}</td>
                                                @if ($index == 0)
                                                    <td class="text-center" rowspan="{{ $size }}">
                                                        {{ $formasiData->total }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        @else
            <div class="flex-shrink-0 alert alert-primary">
                Belum ada Formasi pada Unit Kerja/Instansi Daerah
            </div>
        @endif
    </div>
    <!--end row-->
@endsection
