@extends('layout.v_wrapper')
@section('title')
    Review Import Riwayat Ukom
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="main-table table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Nama Unit Kerja/Instansi Daerah</th>
                                <th class="text-center">Provinsi</th>
                                <th class="text-center">Kabupaten</th>
                                <th class="text-center">Kota</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Jenjang</th>
                                <th class="text-center">jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($userUkomList))
                                @foreach ($userUkomList as $index => $ukom)
                                    <td class="text-center">{{ $formasi->unitKerja->name }}</td>
                                    <td class="text-center">{{ $formasi->unitKerja->instansi->provinsi->name ?? '-' }}</td>
                                    <td class="text-center">{{ $formasi->unitKerja->instansi->kabupaten->name ?? '-' }}</td>
                                    <td class="text-center">{{ $formasi->unitKerja->instansi->kota->name ?? '-' }}</td>
                                    <td class="text-center">{{ $formasi->jabatan->name }}</td>
                                    <td class="text-center">{{ $result->jenjang->name }}</td>
                                    <td class="text-center">{{ $result->pembulatan }}</td>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
