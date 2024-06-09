<div>
    <form wire:submit.prevent="store">
        @csrf
        <table class="table table-striped">
            <thead>
                <tr class="text-center font-12">
                    <th>No</th>
                    <th class="text-center">Nama Jabatan </th>
                    <th class="text-center">Jenjang Jabatan</th>
                    <th class="text-center">Rekapitulasi Usulan Formasi</th>
                    <th class="text-center">Rekomendasi Formasi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @php
                    $formasiResult = $formasi->formasiResult;
                    $size = count($formasiResult);
                @endphp
                @if ($formasiResult->isNotEmpty())
                    @foreach ($formasiResult as $index => $item)
                        <tr>
                            @if ($index == 0)
                                <td rowspan="{{ $size }}">1</td>
                                <td rowspan="{{ $size }}">{{ $formasi->jabatan->name }}</td>
                            @endif
                            <td>{{ $formasi->jabatan->name }} Ahli {{ $item->jenjang->name }}</td>
                            <td>{{ $item->pembulatan }}</td>
                            <td>
                                <input type="text" class="form-control">
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-start fw-bold" colspan="3">Jumlah Usulan Formasi</td>
                        <td>{{ $formasi->total }}</td>
                        <td>{{ $formasi->total }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="btn-group float-end mb-3">
            <a wire:click="$set('isUpdateForm', {{ !$isUpdateForm }})"
                class="btn btn-sm btn-soft-info">Lihat</a>
            <button wire:click="verifikasiFormasi" class="btn btn-sm btn-soft-success">Terima</button>
        </div>
    </form>
</div>
