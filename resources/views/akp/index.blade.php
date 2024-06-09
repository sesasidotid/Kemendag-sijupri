@extends('layout.v_wrapper')
@section('content')
    <div class="row">
        <div class="card" id="applicationList">
            <div class="col-xxl-6">
                <div class="card-body">
                    <div>
                        <table class="main-table table table-bordered nowrap align-middle w-100">
                            <thead class="bg-light  ">
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja/Instansi Daerah</th>
                                    <th>Formasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($formasiList))
                                    @foreach ($formasiList as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->unitKerja->name }}</td>
                                            <td>{{ $item->jabatan->name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('/formasi/detail', $item->id) }}"
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
