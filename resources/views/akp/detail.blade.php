@extends('layout.v_wrapper')
@section('content')
    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" active data-bs-toggle="tab" href="#rekapitulasi" role="tab"
                                aria-selected="true">
                                Rekapitulasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#unsur" role="tab" aria-selected="false">
                                Unsur
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="rekapitulasi" role="tabpanel">
                            <div class="card shadow-sm p-2">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-center font-12">
                                            <th>No</th>
                                            <th class="text-center">Nama Jabatan </th>
                                            <th class="text-center">Jenjang Jabatan</th>
                                            <th class="text-center">Penetapan Formasi Jabatan</th>
                                            <th class="text-center">Jumlah Formasi Yang Diusulkan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @php
                                            $formasiResult = $formasiData->formasiResult;
                                            $size = count($formasiResult);
                                        @endphp
                                        @if ($formasiResult->isNotEmpty())
                                            @foreach ($formasiResult as $index => $item)
                                                <tr>
                                                    @if ($index == 0)
                                                        <td rowspan="{{ $size }}">1</td>
                                                        <td rowspan="{{ $size }}">{{ $formasiData->jabatan->name }}
                                                        </td>
                                                    @endif
                                                    <td>{{ $formasiData->jabatan->name }} Ahli {{ $item->jenjang->name }}
                                                    </td>
                                                    <td>{{ $item->pembulatan }}</td>
                                                    @if ($index == 0)
                                                        <td rowspan="{{ $size }}">{{ $formasiData->total }}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <td colspan="5">Belum ada Hasil Rekapitulasi</td>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="unsur" role="tabpanel">
                            <div>
                                <link href="{{ asset('starter/float/dist/mfb.css') }}" rel="stylesheet">
                                <script src="{{ asset('starter/float/src/mfb.js') }}"></script>
                                <div class="p-2" style="border-radius: 10px">
                                    <form wire:submit.prevent="store">
                                        @csrf
                                        @if ($formasiData->task_status == 'PENDING')
                                            <input type="text"
                                                class="form-control w-100 is-valid text-success bg-white p-3 m-3" disabled
                                                value="Menunggu Verifikasi">
                                        @endif
                                        <div class="row">
                                            <div class="text-center text-dark h6 col">Unsur</div>
                                            <div class="text-center text-dark h6 col-2">Volume <br> (Inputan Pertahun)</div>
                                            <div class="text-center text-dark h6 col-1">Jenjang</div>
                                        </div>
                                        <hr class="bg-dark">
                                        @include('formasi._unsur', ['child' => $formasiUnsurList])
                                        @if ($formasiData->task_status != 'PENDING')
                                            <ul id="menu" class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
                                                <li class="mfb-component__wrap">
                                                    <div class="btn-group " role="group" aria-label="Basic example">
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endif
                                    </form>
                                    <link rel="stylesheet" href="{{ asset('auth/ef.css') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!--end col-->
    </div>
    <!--end row-->
@endsection
