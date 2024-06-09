@extends('layout.v_wrapper')
@section('title')
    Profil
@endsection
@section('content')
    <div class="row">
        <!--end col-->
        <div class="col-md-12">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                </div>
                <div class="p-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="NIP" class="form-label">
                                    <span class="text-danger fw-bold">*</span> NIP
                                </label>
                                <input type="text" class="form-control" id="NIP" disabled
                                    value="{{ $user->nip ?? '' }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="Nama" class="form-label">
                                    <span class="text-danger fw-bold">*</span> Nama
                                </label>
                                <input type="text" class="form-control" id="Nama" disabled
                                    value="{{ $user->name ?? '' }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="Role" class="form-label">
                                    <span class="text-danger fw-bold">*</span> Role
                                </label>
                                <input type="text" class="form-control" id="Role" disabled
                                    value="{{ $user->role->name ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
