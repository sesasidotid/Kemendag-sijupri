@extends('layout.v_wrapper')
@section('title')
    Form Unit Unit Kerja/Instansi Daerah
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}" />
@endpush
@push('ext_footer')
    @include('layout.js_select')
    <script src="{{ asset('leaflet/leaflet.js') }}"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('/maintenance/unit_kerja_instansi_daerah/store') }}" class="mb-3">
                        @csrf
                        @if ($instansi)
                            @if (!in_array($instansi->tipe_instansi_code, ['kementerian_lembaga', 'pusbin']))
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">WIlayah</label>
                                        <select name="wilayah_code"
                                            class="form-control @error('request.wilayah_code') is-invalid @enderror">
                                            <option selected>Pilih WIlayah</option>
                                            @foreach ($wilayahList as $item)
                                                <option value="{{ $item->code }}">{{ $item->region }}</option>
                                            @endforeach
                                        </select>
                                        @error('request.wilayah_code')
                                            <span class="invalid-feedback">
                                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @elseif ($provinsi)
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="mdi mdi-card-account-details mr-2"></i>
                                        Provinsi
                                    </label>
                                    <input type="text" class="form-control" disabled value="{{ $provinsi->name }}">
                                </div>
                            @endif
                            @if ($kabupaten)
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="mdi mdi-card-account-details mr-2"></i>
                                        Kabupaten :
                                    </label>
                                    <input type="text" class="form-control" disabled value="{{ $kabupaten->name }}">
                                </div>
                            @endif
                            @if ($kota)
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="mdi mdi-card-account-details mr-2"></i>
                                        Kota :
                                    </label>
                                    <input type="text" class="form-control" disabled value="{{ $kota->name }}">
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="mdi mdi-card-account-details mr-2"></i>
                                    Nama Instansi
                                </label>
                                <input type="text" class="form-control" disabled value="{{ $instansi->name }}">
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="mb-3 has-validation">
                                <label class="form-label">Nama Unit Kerja/Instansi Daerah</label>
                                <input name="name" type="text" class="form-control"
                                    placeholder="Nama Unit Kerja/Instansi Daerah" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 has-validation">
                                <label class="form-label">E-mail</label>
                                <input name="email" type="email" class="form-control" placeholder="email"
                                    value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 has-validation">
                                <label class="form-label">No HP</label>
                                <input name="phone" type="text" class="form-control" placeholder="Nomor HP"
                                    value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Alamat Instansi</label>
                                <textarea name="alamat" class="form-control" rows="4" placeholder="exp : Jln. Adisucipt , no.8, Kupang">{{ old('alamat') }}</textarea>
                            </div>
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-sm btn-soft-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div id="map" class="w-100" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('ext_footer')
    <script>
        var map, marker;
        const lat = document.getElementById('latitude').value;
        const long = document.getElementById('longitude').value;

        function setMap() {
            map = L.map('map').setView([1.14, 126.21], 4);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            if (lat && long) marker = L.marker([lat, long], {
                icon: getYellowIcon()
            }).addTo(map);

            map.on('click', function(e) {
                if (!marker) {
                    marker = L.marker(e.latlng, {
                        icon: getYellowIcon()
                    }).addTo(map);
                } else {
                    marker.setLatLng(e.latlng);
                }
                document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
            });
        }
    </script>
@endpush
