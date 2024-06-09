@extends('layout.v_wrapper')
@section('title')
    Pemetaan Kinerja
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 31px !important;
        }

        .select2-selection__arrow {
            height: 31px !important;
        }
    </style>
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.tables_s')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <form method="GET" action="">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 alert alert-primary w-100">
                            Pemetaan Jabatan Fungsional Pengguna PAK
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nip</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[nip]"
                                value="{{ request('attr.nip') }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nama</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[name]"
                                value="{{ request('attr.name') }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0">Jabatan Fungsional</label>
                            <select class="js-example-basic-single" name="attr[role_code]">
                                <option value="" {{ !request('attr.role_code') ? 'selected' : '' }}>
                                    Semua
                                </option>
                                <option value="user_external"
                                    {{ request('attr.role_code') == 'user_external' ? 'selected' : '' }}>
                                    Eksternal
                                </option>
                                <option value="user_internal"
                                    {{ request('attr.role_code') == 'user_internal' ? 'selected' : '' }}>
                                    Internal
                                </option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0">Provinsi</label>
                            <select class="js-example-basic-single" name="attr[instansi][provinsi_id]">
                                <option value="" {{ !request('attr.instansi.provinsi_id') ? 'selected' : '' }}>
                                    Pilih Provinsi</option>
                                @if (isset($provinsiList))
                                    @foreach ($provinsiList as $index => $provinsi)
                                        <option value="{{ $provinsi->id }}"
                                            {{ request('attr.instansi.provinsi_id') == $provinsi->id ? 'selected' : '' }}>
                                            {{ $provinsi->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-3 mt-2">
                            <label for="" class="m-0 p-0">Kabupaten/Kota</label>
                            <select class="js-example-basic-single" name="attr[instansi][kabKota][kabupaten_id]">
                                <option value="">Pilih Kabupaten/Kota</option>
                                @if (isset($kabkotaList))
                                    @foreach ($kabkotaList as $index => $kabkota)
                                        <option value="{{ $kabkota->id }}"
                                            {{ request('attr.instansi.kabKota.kabupaten_id') == $kabkota->id ? 'selected' : '' }}>
                                            {{ $kabkota->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-3 mt-2">
                            <label for="" class="m-0 p-0">Instansi</label>
                            <select class="js-example-basic-single" name="attr[instansi_id]">
                                <option value="">Pilih Instansi</option>
                                @if (isset($instansiList))
                                    @foreach ($instansiList as $index => $instansi)
                                        <option value="{{ $instansi->id }}"
                                            {{ request('attr.instansi_id') == $instansi->id ? 'selected' : '' }}>
                                            {{ $instansi->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-3 mt-2">
                            <label for="" class="m-0 p-0">Unit Kerja/Instansi Daerah</label>
                            <select class="js-example-basic-single" name="attr[unit_kerja_id]">
                                <option value="">Pilih Unit Kerja/Instansi Daerah</option>
                                @if (isset($unitkerjaList))
                                    @foreach ($unitkerjaList as $index => $unitkerja)
                                        <option value="{{ $unitkerja->id }}"
                                            {{ request('attr.unit_kerja_id') == $unitkerja->id ? 'selected' : '' }}>
                                            {{ $unitkerja->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="w-100">
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Cari</button>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <div>
                    <table class="main-table table table-bordered nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Provinsi</th>
                                <th class="text-center">Kabupaten/Kota</th>
                                <th class="text-center">Unit Kerja/Instansi Daerah</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userList as $index => $user)
                                <tr>
                                    <td style="font-size: 0.9rem">{{ $index + 1 }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">{{ $user->nip }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">{{ $user->name }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        {{ $user->instansi->provinsi->name ?? '-' }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        {{ $user->unitKerja->kabubaten->name ?? ($user->instansi->kota->name ?? '-') }}
                                    </td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        {{ $user->unitKerja->name ?? '-' }}
                                    </td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        <div class="dropdown d-inline-block">
                                            <a href="{{ route('/monitoring_kinerja/pemetaan_kinerja/detail', ['nip' => $user->nip]) }}"
                                                class="btn btn-soft-primary btn-sm " aria-expanded="false">Detail PAK
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $userList->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
