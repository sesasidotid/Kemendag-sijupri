@if ($object->latitude && $object->longitude)
    <div id="pemetaan_content_{{ $i }}" style="display: none">
        @if ($object->provinsi)
            <label for="">Provinsi : {{ $object->provinsi->name }}</label>
        @endif
        @if ($object->kabupaten)
            <label for="">Kabupaten : {{ $object->kabupaten->name }}</label>
        @endif
        @if ($object->kota)
            <label for="">Kota : {{ $object->kota->name }}</label>
        @endif
        <label for="">Formasi Pada : {{ $object->name }}</label>
        <hr>
        <div class="formasi-content" style="overflow-y: auto; max-height: 400px;">
            @php $formasiList = $object->formasiList() ?? null; @endphp
            @if ($formasiList && count($formasiList) > 0)
                <table class="w-100">
                    @foreach ($formasiList as $item)
                        <tr>
                            <td class="fw-bold" colspan="3">{{ $item->jabatan }}</td>
                        </tr>
                        <tr>
                            <td>pemula</td>
                            <td>:</td>
                            <td class="fw-bold">{{ $item->pemula_sum ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>terampil</td>
                            <td>:</td>
                            <td class="fw-bold">{{ $item->terampil_sum ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>mahir</td>
                            <td>:</td>
                            <td class="fw-bold">{{ $item->mahir_sum ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>penyelia</td>
                            <td>:</td>
                            <td class="fw-bold">{{ $item->penyelia_sum ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>pertama</td>
                            <td>:</td>
                            <td class="fw-bold">{{ $item->pertama_sum ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>muda</td>
                            <td>:</td>
                            <td class="fw-bold">{{ $item->muda_sum ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>madya</td>
                            <td>:</td>
                            <td class="fw-bold">{{ $item->madya_sum ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>utama</td>
                            <td>:</td>
                            <td class="fw-bold">{{ $item->utama_sum ?? 0 }}</td>
                        </tr>
                        <tr class="border border-bottom border-2 broder-dark"></tr>
                    @endforeach
                </table>
            @else
                <label for="">Data tidak ditemukan</label>
            @endif
        </div>
    </div>
    <script>
        var object = @json($object);
        var id = 'pemetaan_content_' + '{{ $i }}';
        content.push({
            id: id,
            minZoom: '{{ $minZoom }}',
            maxZoom: '{{ $maxZoom }}',
            icon: '{{ $icon }}',
            latitude: object.latitude,
            longitude: object.longitude,
        })
    </script>
@endif
