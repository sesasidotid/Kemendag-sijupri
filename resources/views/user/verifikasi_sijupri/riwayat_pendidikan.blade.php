<table class="main-table table nowrap align-middle" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Tingkat Pendidikan</th>
            <th>Jurusan/Program Studi</th>
            <th>Tanggal Ijazah</th>
            <th>File Ijazah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userPendidikanList as $index => $pendidikan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pendidikan->level }}</td>
                <td>{{ $pendidikan->jurusan }}</td>
                <td>{{ $pendidikan->bulan_kelulusan }}</td>
                <td>
                    <a class="link-info" href="javascript:void(0);"
                        onclick="previewModal({{ json_encode($pendidikan->file_ijazah ?? '-') }}, 'File Ijazah')">
                        Lihat <i class=" las la-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
