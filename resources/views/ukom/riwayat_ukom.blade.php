@extends('layout.v_wrapper')
@section('title')
    Riwayat Ukom
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
                    Daftar Riwayat Ukom
                </div>
            </div>
            <div class="card-body">
                <div>
                    <table class="main-table table table-bordered nowrap align-middle w-100" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">UKom Periode</th>
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
                                        <td class="text-center">
                                            {{ date('F Y', strtotime($ukom->ukomPeriode->periode ?? '')) }}
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
                                                <a href="{{ route('/ukom/riwayat_ukom/detail', ['id' => $ukom->id]) }}"
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
