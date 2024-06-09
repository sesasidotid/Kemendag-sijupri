<div>
    <table id="scroll-horizontal" class=" table table-bordered nowrap align-middle w-100">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Operasional</th>
                <th>Provinsi</th>
                <th>Kabupaten</th>
                <th>Kota</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($untiKerjaList))
                @foreach ($untiKerjaList as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->operasional }}</td>
                        <td>{{ $item->provinsi->name ?? '-' }}</td>
                        <td>{{ $item->kabupaten->name ?? '-' }}</td>
                        <td>{{ $item->kota->name ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('formasi.admin.opd', $item->id) }}" class="link-info border-end pe-1">
                                Detail
                                <i class="mdi mdi-eye link-info"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
