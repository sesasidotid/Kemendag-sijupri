<div class="card shadow-sm p-2">
    <table class="main-table">
        <thead>
            <tr class="text-center font-12">
                <th>No</th>
                <th class="text-center">Nama Jabatan </th>
                <th class="text-center">Jenjang Jabatan</th>
                <th class="text-center">Rekapitulasi Usulan Formasi</th>
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
                            <td rowspan="{{ $size + 1 }}">1</td>
                            <td rowspan="{{ $size }}">{{ $formasi->jabatan->name }}</td>
                        @endif
                        <td class="text-dark fw-normal text-start">{{ $item->jenjang->name }}</td>
                        <td>{{ $item->pembulatan }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-dark text-start">Jumlah Formasi Yang Diusulkan</td>
                    <td class="text-dark fw-bold">{{ $formasi->total }}</td>
                </tr>
            @else
                <td colspan="5">Belum ada Hasil Rekapitulasi</td>
            @endif
        </tbody>
    </table>
</div>
