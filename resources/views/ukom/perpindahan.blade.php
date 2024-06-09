@extends('layout.v_wrapper')
@section('title')
    Pendaftaran Ukom Perpindahan Jabatan
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
    <div class="col-lg-12">
        <div class="card-header align-items-center d-flex">
        </div><!-- end card header -->
        <div class="card">
            <div class="card-body">
                <div class="flex-shrink-0 alert alert-primary">
                    Pendaftaran Ukom Kenaikan Jenjang
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row text-dark">
                            <div class="col-3">Nama</div>
                            <div class="col">{{ $user->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Tempat, Tanggal Lahir</div>
                            <div class="col">
                                {{ $user->userDetail->tempat_lahir }},
                                {{ $user->userDetail->tanggal_lahir }}
                            </div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Jenis Kelamin</div>
                            <div class="col">{{ $user->userDetail->jenis_kelamin }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Jabatan</div>
                            <div class="col">{{ $user->jabatan->jabatan->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Jenjang</div>
                            <div class="col">{{ $user->jabatan->jenjang->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Pangkat</div>
                            <div class="col">{{ $user->pangkat->pangkat->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Unit Kerja</div>
                            <div class="col">{{ $user->unitKerja->name }}</div>
                        </div>
                        <div class="row text-dark">
                            <div class="col-3">Alamat Unit Kerja</div>
                            <div class="col">{{ $user->unitKerja->alamat }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if ($ukomPeriode)
                    <H4 class="text-center">Ukom Periode
                        {{ \Carbon\Carbon::parse($ukomPeriode->periode)->locale('id')->translatedFormat('F Y') }}</H4>
                    <form method="POST" action="{{ route('/ukom/perpindahan_jabatan/store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="col-12 mb-3">
                                <label for="">Periode UKom</label>
                                <select class="js-example-basic-single @error('ukom_periode_id') is-invalid @enderror"
                                    name="ukom_periode_id">
                                    <option value="" {{ old('ukom_periode_id') == '' ? 'selected' : '' }}>
                                        Pilih Periode
                                    </option>
                                    @if (isset($ukomPeriodeList))
                                        @foreach ($ukomPeriodeList as $index => $ukomPeriode)
                                            <option value="{{ $ukomPeriode->id }}"
                                                {{ old('ukom_periode_id') == $ukomPeriode->id ? 'selected' : '' }}>
                                                {{ date('F Y', strtotime($ukomPeriode->periode)) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('ukom_periode_id')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Tujuan Jabatan</label>
                                <select class="js-example-basic-single @error('tujuan_jabatan_code') is-invalid @enderror"
                                    name="tujuan_jabatan_code">
                                    <option value="" {{ old('tujuan_jabatan_code') == '' ? 'selected' : '' }}>
                                        Pilih Tujuan Jabatan
                                    </option>
                                    @if (isset($jabatanList))
                                        @foreach ($jabatanList as $index => $jabatan)
                                            <option value="{{ $jabatan->id }}"
                                                {{ old('tujuan_jabatan_code') == $jabatan->code ? 'selected' : '' }}>
                                                {{ $jabatan->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('tujuan_jabatan_code')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Tipe Pendaftaran</label>
                                <select class="js-example-basic-single @error('type') is-invalid @enderror" name="type">
                                    <option value="baru" {{ old('type') == 'baru' ? 'selected' : '' }}>
                                        Baru
                                    </option>
                                    <option value="mengulang" {{ old('type') == 'mengulang' ? 'selected' : '' }}>
                                        Mengulang
                                    </option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- ------------------------------ --}}
                            @foreach ($filePersyaratan['values'] as $index => $file)
                                <div class="col-md-12 mb-3">
                                    <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i>
                                        {{ $file }}
                                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                    </label>
                                    <input type="file" accept=".pdf"
                                        class="form-control @error("{{ str_replace(' ', '_', strtolower($file)) }}") is-invalid @enderror"
                                        name="{{ str_replace(' ', '_', strtolower($file)) }}" id="employeeName"
                                        placeholder="Enter emploree name"
                                        value="{{ old(str_replace(' ', '_', strtolower($file))) ?? '' }}">
                                    @error("{{ str_replace(' ', '_', strtolower($file)) }}")
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach
                            <div>
                                <button type="submit" class="btn btn-primary float-end">
                                    Simpan <i class=" las la-save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <h4>Pendaftaran Ukom Belum Dibuka</h4>
                @endif
                @include('widget.modal-doc')
            </div>
        </div>
    </div>
@endsection
