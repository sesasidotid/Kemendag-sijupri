@extends('layout.v_wrapper')
@section('title')
    Import Data Pertama Formasi
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('/formasi/import/template') }}">
                        @csrf
                        Download
                        <button type="submit" class="btn btn-light link-primary">
                            Template
                        </button>
                    </form>
                    <hr>
                    <form method="POST" action="{{ route('/formasi/import/create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="FileFormasi" class="form-label">
                                        <span class="text-danger fw-bold">*</span> File Formasi
                                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                    </label>
                                    <input name="file_formasi" type="file" accept=".pdf" class="form-control"
                                        id="FileFormasi" />
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-secondary btn-sm float-end">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection
