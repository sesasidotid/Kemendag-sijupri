@extends('layout.v_wrapper')
@section('title')
    Detail ADMIN SI JUPRI
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="row">
        <!--end col-->
        <div class="col-md-12">
            <!-- <div class="card mt-xxl-n5"> -->
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body p-2">
                    <form method="POST" action="{{ route('/security/user/edit', ['nip' => $detailUser->nip]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="NIP" class="form-label">
                                        <span class="text-danger fw-bold">*</span> NIP
                                    </label>
                                    <input type="text" class="form-control" id="NIP" disabled
                                        value="{{ $detailUser->nip }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="Nama" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Nama
                                    </label>
                                    <input type="text" class="form-control" id="Nama" disabled
                                        value="{{ $detailUser->name }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="Status" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Status
                                    </label>
                                    <select id="user_status" name="user_status" class="form-control">
                                        <option value="ACTIVE" {{ $detailUser->user_status == 'ACTIVE' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="NOT_ACTIVE"
                                            {{ $detailUser->user_status == 'NOT_ACTIVE' ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="Role" class="form-label">
                                        <span class="text-danger fw-bold">*</span> Role
                                    </label>
                                    <select id="role_code" name="role_code" class="form-control">
                                        @foreach ($roleData as $role)
                                            <option @if ($role->code == $detailUser->role_code) selected @endif
                                                value="{{ $role->code }}">{{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label><b>Metode Akses</b></label>
                                <table>
                                    <tr>
                                        <td class="text-center p-2">
                                            <label class="form-label">
                                                Read
                                            </label>
                                            <input type="checkbox" class="form-check-input" disabled checked
                                                name="access_method[read]">
                                        </td>
                                        <td class="text-center p-2">
                                            <label class="form-label">
                                                Create
                                            </label>
                                            <input type="checkbox" class="form-check-input"
                                                @if ($detailUser->access_method['create'] ?? false) checked @endif
                                                name="access_method[create]">
                                        </td>
                                        <td class="text-center p-2">
                                            <label class="form-label">
                                                Update
                                            </label>
                                            <input type="checkbox" class="form-check-input"
                                                @if ($detailUser->access_method['update'] ?? false) checked @endif
                                                name="access_method[update]">
                                        </td>
                                        <td class="text-center p-2">
                                            <label class="form-label">
                                                Delete
                                            </label>
                                            <input type="checkbox" class="form-check-input"
                                                @if ($detailUser->access_method['delete'] ?? false) checked @endif
                                                name="access_method[delete]">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-danger" name="delete_flag" value="true">
                                        Hapus
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
