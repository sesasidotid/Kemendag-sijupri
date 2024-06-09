@extends('layout.v_wrapper')
@section('title')
    Import Riwayat Ukom
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="FileRiwayatUkom" class="form-label">
                                        <span class="text-danger fw-bold">*</span> File Riwayat Ukom
                                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                    </label>
                                    <input wire:model="request.file_riwayat_ukom" type="file" accept=".pdf"
                                        class="form-control @error('request.file_riwayat_ukom') is-invalid @enderror"
                                        id="FileRiwayatUkom" />
                                    @error('request.file_riwayat_ukom')
                                        <span class="invalid-feedback">
                                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                                        </span>
                                    @enderror
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
