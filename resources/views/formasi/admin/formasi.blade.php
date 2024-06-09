@extends('layout.v_wrapper')
@section('title')
    Formasi
@endsection
@section('content')
    <div class="row">
        <div class="card" id="applicationList">
            <div class="card-header bg-light border-0">
                <h5 class="card-title mb-md-0 flex-grow-1">
                    Unit Kerja/Instansi Daerah {{ $unitKerja->name }} ({{ $unitKerja->operasional }})
                </h5>
            </div>
            <div class="card-body justify-content-start d-print-none">
                @if (isset($unitKerja->instansi->provinsi))
                    <div class="hstack gap-2">
                        <div style="width: 10%">Provinsi</div>
                        <div>:</div>
                        <div>{{ $unitKerja->instansi->provinsi->name }}</div>
                    </div>
                @endif
                @if (isset($unitKerja->instansi->kabupaten))
                    <div class="hstack gap-2 mt-2">
                        <div style="width: 10%">Kabupaten</div>
                        <div>:</div>
                        <div>{{ $unitKerja->instansi->kabupaten->name }}</div>
                    </div>
                @endif
                @if (isset($unitKerja->instansi->kota))
                    <div class="hstack gap-2 mt-2">
                        <div style="width: 10%">Kota</div>
                        <div>:</div>
                        <div>{{ $unitKerja->instansi->kota->name }}</div>
                    </div>
                @endif
                <div class="hstack gap-2 mt-2">
                    <div style="width: 10%">Email</div>
                    <div>:</div>
                    <div>{{ $unitKerja->email ?? '-' }}</div>
                </div>
                <div class="hstack gap-2 mt-2">
                    <div style="width: 10%">Phone</div>
                    <div>:</div>
                    <div>{{ $unitKerja->phone ?? '-' }}</div>
                </div>
                <div class="hstack gap-2 mt-2">
                    <div style="width: 10%">Alamat</div>
                    <div>:</div>
                    <div>{{ $unitKerja->alamat ?? '-' }}</div>
                </div>
            </div>
        </div><!--end row-->
        <div class="card" id="applicationList">
            <div class="card-header bg-light border-0">
                <h5 class="card-title mb-md-0 flex-grow-1">
                    Data Formasi
                </h5>
            </div>
            <div class="col-xxl-6">
                <div class="card-body">
                    <div>
                        <table id="scroll-horizontal" class=" table table-bordered nowrap align-middle w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Operasional</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Kota</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($formasiList))
                                    @foreach ($formasiList as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->jabatan->name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('formasi.admin.detail', $item->id) }}"
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
                </div><!-- end card-body -->
            </div><!--end col-->
        </div><!--end row-->
    </div>
    <!--end row-->
@endsection
