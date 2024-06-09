@extends('layout.v_wrapper')
@section('title')
    Pemetaan Formasi Seluruh Indonesia
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}" />
    <style>
        .div-container {
            position: relative;
        }

        .div1,
        .div2 {
            position: absolute;
        }

        .div1 {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
        }

        .div2 {
            bottom: 10px;
            left: 10px;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
        }
    </style>
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
                    Peta Persebaran Formasi
                </div>
            </div>
            <div class="card-body row">
                <div class="col-8 container">
                    <div id="map" class="w-100 div1" style="height: 500px;"></div>
                    <div class="div2">
                        <table>
                            <tr>
                                <td><img src="{{asset('leaflet/images/marker-icon-red.png')}}" alt="" height="15px"></td>
                                <td>---</td>
                                <td>Provinsi</td>
                            </tr>
                            <tr>
                                <td><img src="{{asset('leaflet/images/marker-icon-blue.png')}}" alt="" height="15px"></td>
                                <td>---</td>
                                <td>Kabupaten/Kota</td>
                            </tr>
                            <tr>
                                <td><img src="{{asset('leaflet/images/marker-icon-yellow.png')}}" alt="" height="15px"></td>
                                <td>---</td>
                                <td>Unit Kerja/Instansi Daerah</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-4 border-start border-dark border-2" style="height: 500px;">
                    <h6>Detail Formasi</h6>
                    @php $i = 0; @endphp
                    <script>
                        const content = [];
                    </script>
                    @foreach ($provinsiList as $index => $provinsi)
                        @include('formasi.pemetaan_formasi_table', [
                            'i' => $i,
                            'minZoom' => 0,
                            'maxZoom' => 100,
                            'object' => $provinsi,
                            'icon' => 'red',
                        ])
                        @php $i = $i + 1; @endphp
                    @endforeach
                    @foreach ($kabKotaList as $index => $kabKota)
                        @include('formasi.pemetaan_formasi_table', [
                            'i' => $i,
                            'minZoom' => 0,
                            'maxZoom' => 100,
                            'object' => $kabKota,
                            'icon' => 'blue',
                        ])
                        @php $i = $i + 1; @endphp
                    @endforeach
                    @foreach ($unitKerjaList as $index => $unitKerja)
                        @include('formasi.pemetaan_formasi_table', [
                            'i' => $i,
                            'minZoom' => 0,
                            'maxZoom' => 100,
                            'object' => $unitKerja,
                            'icon' => 'yellow',
                        ])
                        @php $i = $i + 1; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('ext_footer')
    <script>
        function setMap() {
            const markerIcons = {
                red: getRedIcon(),
                blue: getBlueIcon(),
                yellow: getYellowIcon(),
            }

            var map = L.map('map').setView([1.14, 117.95], 4);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            content.forEach(object => {
                object.marker = L.marker([object.latitude, object.longitude], {
                    icon: markerIcons[object.icon]
                }).addTo(map);
                object.marker.on('click', function(e) {
                    var elements = document.querySelectorAll('[id^="pemetaan_content_"]');
                    elements.forEach(function(element) {
                        element.style.display = 'none';
                    });

                    document.getElementById(object.id).style.display = 'block';
                });
            });

            map.on('zoomend', function() {
                var currentZoom = map.getZoom();

                content.forEach(element => {
                    if (currentZoom <= element.maxZoom && currentZoom >= element.minZoom) {
                        element.marker.addTo(map);
                    } else {
                        map.removeLayer(element.marker);
                    }
                });
            });
        }
    </script>
@endpush
