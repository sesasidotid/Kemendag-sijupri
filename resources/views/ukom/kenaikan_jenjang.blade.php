@extends('layout.v_wrapper')
@section('title')
    Pendaftaran Ukom Kenaikan Jenjang
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
                        <hr>
                        <div class="row text-primary">
                            <div class="col-3">Jenjang Tujuan</div>
                            <div class="col">{{ $nextJenjang->name }}</div>
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
                    <form method="POST" action="{{ route('/ukom/kenaikan_jenjang/store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="col-12 mb-3">
                                <label for="">Tipe Pendaftaran</label>
                                <select class="js-example-basic-single" name="type">
                                    <option value="baru" {{ old('type') == 'baru' ? 'selected' : '' }}>
                                        Baru
                                    </option>
                                    <option value="mengulang" {{ old('type') == 'mengulang' ? 'selected' : '' }}>
                                        Mengulang
                                    </option>
                                </select>
                            </div>
                            {{-- ------------------------------ --}}
                            @foreach ($filePersyaratan['values'] as $index => $file)
                                <div class="col-md-12 mb-3">
                                    <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i>
                                        {{ $file }}
                                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                    </label>
                                    <input type="file" accept=".pdf" class="form-control"
                                        name="{{ str_replace(' ', '_', strtolower($file)) }}" id="employeeName"
                                        placeholder="Enter emploree name"
                                        value="{{ old(str_replace(' ', '_', strtolower($file))) ?? '' }}">
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
