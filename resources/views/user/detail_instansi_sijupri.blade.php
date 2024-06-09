@extends('layout.v_wrapper')
@section('title')
    Detail Admin Instansi
@endsection
@section('js_select')
    @include('layout.js_select')
@endsection
@section('css_tables')
    @include('layout.css_tables')
@endsection
@section('js_tables')
    @include('layout.js_tables')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('/user/admin_instansi/edit', ['nip' => $user->nip]) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="NIP" class="form-label">
                                        <span class="text-danger fw-bold">*</span> NIP
                                    </label>
                                    <input type="text" class="form-control" id="NIP" disabled
                                        value="{{ $user->nip }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="Nama" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Nama
                                    </label>
                                    <input type="text" class="form-control" id="Nama" disabled
                                        value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="Status" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Status
                                    </label>
                                    <select id="user_status" name="user_status" class="form-control">
                                        <option value="ACTIVE" {{ $user->user_status == "ACTIVE" ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="NOT_ACTIVE" {{ $user->user_status == "NOT_ACTIVE" ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-danger" name="delete_flag" value="true">
                                        Hapus
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-info">Ubah</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
