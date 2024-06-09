@extends('layout.v_wrapper')
@section('title')
    Detail/Ubah Kabupaten
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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Form Kabupaten
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('/maintenance/kabupaten/update', ['id' => $kabupaten->id]) }}"
                    class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="Provinsi" class="form-label">
                                Provinsi
                            </label>
                            <select class="form-select mb-3" name="provinsi_id" aria-label="Provinsi" id="Provinsi">
                                <option {{ $kabupaten->provinsi_id ? '' : 'selected' }}>Pilih Provinsi</option>
                                @if (isset($provinsiList))
                                    @foreach ($provinsiList as $item)
                                        <option {{ $kabupaten->provinsi_id == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="Nama" class="form-label">
                                Nama
                            </label>
                            <input type="text" class="form-control" name="name" id="Nama"
                                placeholder="Masukkan Nama" value="{{ $kabupaten->name }}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="Deskripsi" class="form-label">
                                Deskripsi
                            </label>
                            <input type="text" class="form-control" name="description" id="Deskripsi"
                                placeholder="Masukkan Deskripsi" value="{{ $kabupaten->description }}">
                        </div>
                    </div>
                    <input type="hidden" name="latitude" id="latitude" value="{{ $kabupaten->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $kabupaten->longitude }}">
                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="submit" class="btn btn-sm btn-soft-info">Ubah</button>
                        </div>
                    </div>
                </form>
                <div id="map" class="w-100" style="height: 500px;"></div>
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
                icon: getBlueIcon()
            }).addTo(map);


            map.on('click', function(e) {
                if (!marker) {
                    marker = L.marker(e.latlng, {
                        icon: getBlueIcon()
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
