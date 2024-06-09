@extends('layout.v_wrapper')
@section('title')
    Daftar AKP
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
            </div><!-- end card header -->
            <div class="card-body">
                <div>
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
                </div><!-- end card-body -->
            </div><!--end col-->
        </div><!--end row-->
    </div>
    <!--end row-->
@endsection
