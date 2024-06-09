@extends('layout.v_wrapper')
@section('title')
    Detail Periode UKom
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
        <div class="card">
            <div class="card-body">
                <div class="card-header align-items-center d-flex">
                    <div class="flex-shrink-0 alert alert-primary w-100">
                        Update Periode UKom
                    </div>
                </div>
                <form action="{{ route('/ukom/periode/edit', ['id' => $ukomPeriode->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row mb-3 gap-2">
                        @php
                            // dd(date('M Y', strtotime($ukomPeriode->periode)));
                        @endphp
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Periode UKOM</label>
                            <input type="month" name="periode" class="form-control" data-provider="flatpickr"
                                data-date-format="Y-m" id="dateInput"
                                value="{{ date('Y-m', strtotime($ukomPeriode->periode)) }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Tanggal Mulai Pendaftaran</label>
                            <input type="date" data-provider="flatpickr" name="tgl_mulai_pendaftaran"
                                class="form-control" data-provider="flatpickr"
                                value="{{ $ukomPeriode->tgl_mulai_pendaftaran }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Tanggal Tutup Pendaftaran</label>
                            <input type="date" data-provider="flatpickr" name="tgl_tutup_pendaftaran"
                                class="form-control" data-provider="flatpickr"
                                value="{{ $ukomPeriode->tgl_tutup_pendaftaran }}">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Judul Pengumuman</label>
                            <div class="mb-3">
                                <input name="judul" type="text" class="form-control"
                                    value="{{ $ukomPeriode->announcement->title }}">
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="" class="form-label">Konten Pengumuman</label>
                            <div class="mb-3">
                                <textarea id="editor" style="display: none;" name="content" id="" cols="30" rows="10"
                                    class="form-control"> 
                                    {!! $ukomPeriode->announcement->content !!}
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary float-end">
                            Ubah <i class=" las la-save"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
