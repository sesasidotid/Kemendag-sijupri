@extends('layout.v_wrapper')
@section('title')
    Data Formasi
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="row">
        <div class="card" id="applicationList">
            <div class="col-md-12">
                <div class="card-body">
                    <div>
                        <table class="main-table table table-bordered nowrap align-middle w-100">
                            <div class="flex-shrink-0 alert alert-primary">
                                Di Bawah ini Merupakan <strong> Data Formasi </strong>
                                <div class="float-end">
                                    Data Formasi :
                                    <a href="{{ route('/formasi/import') }}" class="btn btn-primary btn-sm">
                                        Import<i class="mdi mdi-plus"></i>
                                    </a>
                                </div>
                            </div>
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
                                                <a href="{{ route('/formasi/data_rekomendasi_formasi/detail', $item->id) }}"
                                                    class="btn btn-sm btn-soft-primary">
                                                    Detail
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
