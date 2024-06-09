<table class="main-table table nowrap align-middle" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>TMT</th>
            <th>Jenjang</th>
            <th>SK Jabatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userJabatanList as $index => $jabatan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $jabatan->name }}</td>
                <td>{{ $jabatan->tmt }}</td>
                <td>{{ $jabatan->jenjang->name }}</td>
                <td>
                    <a class="link-info" href="javascript:void(0);"
                        onclick="previewModal({{ json_encode($jabatan->file_sk_jabatan ?? '-') }}, 'SK Jabatan')">
                        Lihat <i class=" las la-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
