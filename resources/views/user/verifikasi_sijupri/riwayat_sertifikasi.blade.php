<table class="main-table table nowrap align-middle" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Nomor SK</th>
            <th>Tanggal SK</th>
            <th>Wilayah Kerja</th>
            <th>Tanggal Berlaku Mulai</th>
            <th>Tanggal Berlaku Sampai</th>
            <th>UU Yang Di Kawal</th>
            <th>Dokumen SK</th>
            <th>KTP PPNS</th>
        </tr>
    </thead>
    <tbody>
        @foreach($userSertifikasiList as $index => $sertifikasi)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $sertifikasi->kategori }}</td>
            <td>{{ $sertifikasi->nomor_sk }}</td>
            <td>{{ $sertifikasi->tanggal_sk }}</td>
            <td>{{ $sertifikasi->wilayah_kerja ?? '' }}</td>
            <td>{{ $sertifikasi->berlaku_mulai ?? '' }}</td>
            <td>{{ $sertifikasi->berlaku_sampai ?? '' }}</td>
            <td>{{ $sertifikasi->file_uu_kawalan }}</td>
            <td>
                <a class="link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($sertifikasi->file_doc_sk ?? '-') }}, 'Dokumen SK')">
                    Lihat <i class=" las la-eye"></i>
                </a>
            </td>
            <td>
                <a class="link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($sertifikasi->file_ktp_ppns ?? '-') }}, 'KTP PPNS')">
                    Lihat <i class=" las la-eye"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
