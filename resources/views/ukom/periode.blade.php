@extends('layout.v_wrapper')
@section('title')
    Periode UKom
@endsection
@push('ext_header')
    @include('layout.css_tables')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
@endpush
@push('ext_footer')
    @include('layout.js_tables')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: '{{ route('/ck_editor_upload') . '?_token=' . csrf_token() }}',
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div class="flex-shrink-0 alert alert-primary">
                    Penaftaran Periode UKom
                </div>
                <form action="{{ route('/ukom/periode/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3 gap-2">
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Periode UKOM</label>
                            <input type="month" name="periode" class="form-control" data-provider="flatpickr"
                                data-date-format="Y-m" id="dateInput"
                                value="{{ old('periode') ? date('Y-m', strtotime(old('periode'))) : '' }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Tanggal Mulai Pendaftaran</label>
                            <input type="date" data-provider="flatpickr" name="tgl_mulai_pendaftaran"
                                class="form-control" data-provider="flatpickr"
                                value="{{ old('tgl_mulai_pendaftaran') ? date('Y-m-d', strtotime(old('tgl_mulai_pendaftaran'))) : '' }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Tanggal Tutup Pendaftaran</label>
                            <input type="date" data-provider="flatpickr" name="tgl_tutup_pendaftaran"
                                class="form-control" data-provider="flatpickr"
                                value="{{ old('tgl_mulai_pendaftaran') ? date('Y-m-d', strtotime(old('tgl_tutup_pendaftaran'))) : '' }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Judul Pengumuman</label>
                            <div class="mb-3">
                                <input name="judul" type="text" class="form-control" placeholder="Judul"
                                    value="{{ old('judul') }}">
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Konten Pengumuman</label>
                            <div class="mb-3">
                                <textarea id="editor" style="display: none;" name="content" id="" cols="30" rows="10"
                                    class="form-control" value="{{ old('content') }}">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary float-end">
                            Simpan <i class=" las la-save"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="main-table table table-nowrap table-striped-columns mb-0 w-100">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Periode</th>
                            <th scope="col">Tanggal Pembukaan Pendaftaran</th>
                            <th scope="col">Tanggal Penutupan Pendaftaran</th>
                            <th scope="col">status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($ukomPeriodeList))
                            @foreach ($ukomPeriodeList as $index => $ukomPeriode)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ date('F Y', strtotime($ukomPeriode->periode)) }}</td>
                                    <td>{{ date('Y-m-d', strtotime($ukomPeriode->tgl_mulai_pendaftaran)) }}</td>
                                    <td>{{ date('Y-m-d', strtotime($ukomPeriode->tgl_tutup_pendaftaran)) }}</td>
                                    <th scope="col">
                                        @if ($ukomPeriode->inactive_flag)
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @else
                                            <span class="badge bg-success"> Aktif</span>
                                        @endif
                                    </th>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('/ukom/periode/detail', ['id' => $ukomPeriode->id]) }}"
                                                class="btn btn-sm btn-soft-info">Detail</a>
                                            @if ($ukomPeriode->inactive_flag)
                                                <a href="{{ route('/ukom/periode/toggle', ['id' => $ukomPeriode->id]) }}"
                                                    class="btn btn-sm btn-soft-success">Aktifkan</a>
                                            @else
                                                <a href="{{ route('/ukom/periode/toggle', ['id' => $ukomPeriode->id]) }}"
                                                    class="btn btn-sm btn-soft-light text-dark">Non Aktifkan</a>
                                            @endif
                                            {{-- <form method="POST"
                                                action="{{ route('/ukom/periode/delete', ['id' => $ukomPeriode->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger">Hapus</button>
                                            </form> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
