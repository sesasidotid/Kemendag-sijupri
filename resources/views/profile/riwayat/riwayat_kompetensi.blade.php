<table class="main-table table nowrap align-middle" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kompentesi</th>
            <th>Kategori Pengembangan</th>
            <th>Tanggal Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userKompetensiList as $index => $kompetensi)
            <tr>
                <th>{{ $index + 1 }}</th>
                <th>{{ $kompetensi->name }}</th>
                <th>{{ $kompetensi->kategori }}</th>
                <th>{{ $kompetensi->tgl_sertifikat }}</th>
            </tr>
        @endforeach
    </tbody>
</table>
