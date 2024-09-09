@extends('layout.v_wrapper')
@section('title')
    Daftar AKP Pengguna JF
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div class="flex-shrink-0 alert alert-primary">
                    Daftar AKP Oleh Pejabat Fungsional
                </div>
                <div class="row text-dark">
                    <div class="col-3">Nama</div>
                    <div class="col">{{ $user->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Tempat, Tanggal Lahir</div>
                    <div class="col">
                        {{ $user->userDetail->tempat_lahir ?? '-' }},
                        {{ substr($user->userDetail->tanggal_lahir ?? '-', 0, 10) }}
                    </div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Jenis Kelamin</div>
                    <div class="col">{{ $user->userDetail->jenis_kelamin ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Jabatan</div>
                    <div class="col">{{ $user->jabatan->jabatan->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Jenjang</div>
                    <div class="col">{{ $user->jabatan->userJabatan->jenjang->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Pangkat</div>
                    <div class="col">{{ $user->pangkat->userPangkat->pangkat->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Unit Kerja</div>
                    <div class="col">{{ $user->unitKerja->name ?? '-' }}</div>
                </div>
                <div class="row text-dark">
                    <div class="col-3">Alamat Unit Kerja</div>
                    <div class="col">{{ $user->unitKerja->alamat ?? '-' }}</div>
                </div>
            </div>
        </div><!--end col-->
        <div class="card">
            <div class="card-body">
                <table class="main-table table table-bordered nowrap align-middle w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>nama</th>
                            <th>Instrumen</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($akpList))
                            @foreach ($akpList as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->akpInstrumen->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('/akp/daftar/detail', $item->id) }}"
                                            class="link-info border-end pe-1">
                                            Detail
                                            <i class="mdi mdi-eye link-info"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end row-->
@endsection
