@extends('layout.v_wrapper')
@section('title')
    Pemetaan Formasi
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
                    Peta Persebaran Formasi
                </div>
            </div>
            <div class="card-body row">
                <div class="col-8">
                    <div id="map" class="w-100" style="height: 500px;"></div>
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
                            'minZoom' => 1,
                            'maxZoom' => 5,
                            'object' => $provinsi,
                        ])
                        @if ($provinsi->kabKota && count($provinsi->kabKota) > 0)
                            @foreach ($provinsi->kabKota as $index => $kabKota)
                                @include('formasi.pemetaan_formasi_table', [
                                    'i' => $i,
                                    'minZoom' => 5,
                                    'maxZoom' => 8,
                                    'object' => $kabKota,
                                ])
                                @if ($kabKota->unitKerja && count($kabKota->unitKerja) > 0)
                                    @foreach ($kabKota->unitKerja as $index => $unitKerja)
                                        @include('formasi.pemetaan_formasi_table', [
                                            'i' => $i,
                                            'minZoom' => 8,
                                            'maxZoom' => 100,
                                            'object' => $unitKerja,
                                        ])
                                        @php $i = $i + 1; @endphp
                                    @endforeach
                                @else
                                    @php $i = $i + 1; @endphp
                                @endif
                            @endforeach
                        @else
                            @php $i = $i + 1; @endphp
                        @endif
                        @if ($provinsi->unitKerja && count($provinsi->unitKerja) > 0)
                            @foreach ($provinsi->unitKerja as $index => $unitKerja)
                                @include('formasi.pemetaan_formasi_table', [
                                    'i' => $i,
                                    'minZoom' => 8,
                                    'maxZoom' => 100,
                                    'object' => $unitKerja,
                                ])
                                @php $i = $i + 1; @endphp
                            @endforeach
                        @else
                            @php $i = $i + 1; @endphp
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('ext_footer')
    <script>
        function setMap() {
            var map = L.map('map').setView([1.14, 126.21], 4);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            content.forEach(object => {
                object.marker = L.marker([object.latitude, object.longitude]).addTo(map);
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
