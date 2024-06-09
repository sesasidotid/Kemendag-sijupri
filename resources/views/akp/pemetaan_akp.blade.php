@extends('layout.v_wrapper')
@section('title')
    Pemetaan AKP
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
    <script>
        function copyUrl(url) {
            const textarea = document.createElement("textarea");
            textarea.value = url;
            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();
            try {
                document.execCommand('copy');
                alert('URL copied to clipboard!');
            } catch (err) {
                console.error(err.message)
            }
            document.body.removeChild(textarea);
        }
    </script>
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <form method="GET" action="">
                <div class="card-header align-items-center d-flex">
                    <div class="row">
                        <div class="col-12 flex-shrink-0 alert alert-primary w-100">
                            Pemetaan Jabatan Fungsional Pengguna AKP
                        </div>
                        <div class="col-3">
                            <label class="m-0 p-0"><small>Nip</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[nip]"
                                value="{{ request('attr.nip') }}">
                        </div>
                        <div class="col-3">
                            <label class="m-0 p-0"><small>Nama</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[name]"
                                value="{{ request('attr.name') }}">
                        </div>
                        <div class="col-3">
                            <label class="m-0 p-0">Jabatan Fungsional</label>
                            <select class="js-example-basic-single" name="attr[role_code]">
                                <option value="">
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
                            <label class="m-0 p-0">Provinsi</label>
                            <select class="js-example-basic-single" name="attr[instansi][provinsi_id]">
                                <option value="">Pilih Provinsi</option>
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
                            <label class="m-0 p-0">Kabupaten/Kota</label>
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
                            <label class="m-0 p-0">Instansi</label>
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
                            <label class="m-0 p-0">Unit Kerja/Instansi Daerah</label>
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
                        <div class="w-100">
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Cari</button>
                        </div>
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
                                        {{ $user->unitKerja->instansi->provinsi->name ?? '-' }}</td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        {{ $user->unitKerja->instansi->kabubaten->name ?? ($user->unitKerja->instansi->kota->name ?? '-') }}
                                    </td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        {{ $user->unitKerja->name ?? '-' }}
                                    </td>
                                    <td class="text-center" style="font-size: 0.9rem">
                                        <div class="dropdown d-inline-block">
                                            <a href="{{ route('/akp/daftar_user_akp', ['nip' => $user->nip]) }}"
                                                class="btn btn-soft-primary btn-sm " aria-expanded="false">List AKP
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a class="btn btn-sm btn-soft-info"
                                                onclick="copyUrl('{{ $user->urlAtasan() }}')">
                                                Url Atasan
                                                <i class="mdi mdi-content-copy link-info"></i>
                                            </a>
                                            <a class="btn btn-sm btn-soft-info"
                                                onclick="copyUrl('{{ $user->urlRekan() }}')">
                                                Url Rekan
                                                <i class="mdi mdi-content-copy link-info"></i>
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
