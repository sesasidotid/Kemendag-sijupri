@extends('layout.v_wrapper')
@section('title')
    Pemetaan UKom
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
                            Pemetaan Hasil Ukom
                            <a href="{{ route('/ukom/import_nilai') }}" class="btn btn-primary btn-sm float-end">IMPORT</a>
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nip</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[nip]"
                                value="{{ request('attr[nip]') }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Email</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[email]"
                                value="{{ request('attr[email]') }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0"><small>Nama</small></label>
                            <input type="text" class="form-control form-control-sm" name="attr[name]"
                                value="{{ request('attr[name]') }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="m-0 p-0">Periode</label>
                            <select class="js-example-basic-single" style="height: 100px" name="attr[ukom_periode_id]">
                                <option value="">Pilih Periode</option>
                                @if (isset($ukomPeriodeList))
                                    @foreach ($ukomPeriodeList as $index => $ukomPeriode)
                                        <option value="{{ $ukomPeriode->id }}"
                                            {{ request('attr[ukom_periode_id]') == $ukomPeriode->id ? 'selected' : '' }}>
                                            {{ date('F Y', strtotime($ukomPeriode->periode)) }}
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
                    <table class="main-table table table-bordered nowrap align-middle w-100" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Periode</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Provinsi</th>
                                <th class="text-center">Kabupaten/Kota</th>
                                <th class="text-center">Unit Kerja</th>
                                <th class="text-center">Nilai CAT</th>
                                <th class="text-center">Nilai Wawancara</th>
                                <th class="text-center">Nilai Seminar</th>
                                <th class="text-center">Nilai Praktik</th>
                                <th class="text-center">NB CAT</th>
                                <th class="text-center">NB Wawancara</th>
                                <th class="text-center">NB Seminar</th>
                                <th class="text-center">NB Praktik</th>
                                <th class="text-center">Total Nilai UKT</th>
                                <th class="text-center">Nilai UKT</th>
                                <th class="text-center">Total Nilai Kompetensi Manajerial</th>
                                <th class="text-center">UKMSK</th>
                                <th class="text-center">Nilai Akhir</th>
                                <th class="text-center">Rekomendasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($ukomList))
                                @foreach ($ukomList as $index => $ukom)
                                    <tr>
                                        <td style="font-size: 0.9rem">{{ $index + 1 }}</td>
                                        <td class="text-center" style="font-size: 0.9rem">
                                            {{ date('F Y', strtotime($ukom->ukomPeriode->periode)) }}
                                        </td>
                                        <td class="text-center" style="font-size: 0.9rem">{{ $ukom->nip }}</td>
                                        <td class="text-center" style="font-size: 0.9rem">{{ $ukom->email ?? '' }}</td>
                                        <td class="text-center" style="font-size: 0.9rem">{{ $ukom->name }}</td>
                                        <td class="text-center" style="font-size: 0.9rem">
                                            {{ $ukom->detail->provinsi_name ?? '-' }}</td>
                                        <td class="text-center" style="font-size: 0.9rem">
                                            {{ $ukom->detail->kabupaten_name ?? ($ukom->detail->kota_name ?? '-') }}
                                        </td>
                                        <td class="text-center" style="font-size: 0.9rem">
                                            {{ $ukom->detail->unit_kerja_name ?? '-' }}
                                        </td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->cat }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->wawancara }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->seminar }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->praktik }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->nb_cat }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->nb_wawancara }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->nb_seminar }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->nb_praktik }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->total_nilai_ukt }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->nilai_ukt }}</td>
                                        <td class="text-center">{{ $ukom->ukomMansoskul->jpm }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->ukmsk }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->nilai_akhir }}</td>
                                        <td class="text-center">{{ $ukom->ukomTeknis->rekomendasi }}</td>
                                        <th class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('/ukom/pemetaan_ukom/detail', ['id' => $ukom->id]) }}"
                                                    class="btn btn-sm btn-soft-primary">
                                                    Detail
                                                </a>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                {{ $ukomList->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
