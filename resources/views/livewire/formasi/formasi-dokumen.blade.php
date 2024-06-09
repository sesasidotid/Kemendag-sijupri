<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center">Status</th>
            <th class="text-center">verifikasi</th>
            <th class="text-center">Lihat</th>
            <th class="text-center">Jenis Dokumen</th>
            <th class="text-center">Upload</th>
            <th class="text-center">Template</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="checkbox" disabled class="form-check-input" @if ($formasiDocument->file_surat_pengajuan_abk) checked @endif>
            </td>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->status_surat_pengajuan_abk) checked @endif>
            <td>
                <a class="link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_surat_pengajuan_abk ?? '') }}, 'Surat Pengajuan ABK')">
                    File<i class="mdi
                    mdi-file-pdf"></i>
                </a>
            </td>
            <td>Surat Pengajuan ABK <strong class="text-info">(file: pdf | max: 2mb)</strong></td>
            <td>
                <input wire:model="request.file_surat_pengajuan_abk" type="file" accept=".pdf"
                    class="form-control" />
            </td>
            <td>
                <a class="custom-file-label fw-800">
                    <i class="mdi mdi-file-document-outline link-info">download</i>
                </a>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->file_struktur_organisasi) checked @endif>
            </td>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->status_struktur_organisasi) checked @endif>
            </td>
            <td>
                <a class="link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_struktur_organisasi ?? '') }}, 'Struktur Organisasi')">
                    File<i class="mdi mdi-file-pdf"></i>
                </a>
            </td>
            <td>Struktur Organisasi <strong class="text-info">(file: pdf | max: 2mb)</strong></td>
            <td><input wire:model="request.file_struktur_organisasi" type="file" accept=".pdf"
                    class="form-control" /></td>
            <td>
                <a class="custom-file-label fw-800">
                    <i class="mdi mdi-file-document-outline link-info">download</i>
                </a>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->file_daftar_susunan_pegawai) checked @endif>
            </td>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->status_daftar_susunan_pegawai) checked @endif>
            </td>
            <td>
                <a class="link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_daftar_susunan_pegawai ?? '') }}, 'Daftar Susunan Pegawai')">
                    File<i class="mdi mdi-file-pdf"></i>
                </a>
            </td>
            <td>Daftar Susunan Pegawai <strong class="text-info">(file: pdf | max: 2mb)</strong></td>
            <td><input wire:model="request.file_daftar_susunan_pegawai" type="file" accept=".pdf"
                    class="form-control" /></td>
            <td>
                <a class="custom-file-label fw-800">
                    <i class="mdi mdi-file-document-outline link-info">download</i>
                </a>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->file_rencana_pemenuhan_kebutuhan_pegawai) checked @endif>
            </td>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->status_rencana_pemenuhan_kebutuhan_pegawai) checked @endif>
            </td>
            <td>
                <a class="link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_rencana_pemenuhan_kebutuhan_pegawai ?? '') }}, 'Rencana Pemenuhan Kebutuhan Pegawai')">
                    File<i class="mdi mdi-file-pdf"></i>
                </a>
            </td>
            <td>Rencana Pemenuhan Kebutuhan Pegawai <strong class="text-info">(file: pdf | max: 2mb)</strong></td>
            <td><input wire:model="request.file_rencana_pemenuhan_kebutuhan_pegawai" type="file" accept=".pdf"
                    class="form-control" /></td>
            <td>
                <a class="custom-file-label fw-800">
                    <i class="mdi mdi-file-document-outline link-info">download</i>
                </a>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->file_potensi_uttp) checked @endif>
            </td>
            <td><input type="checkbox" disabled class="form-check-input"
                    @if ($formasiDocument->status_potensi_uttp) checked @endif>
            </td>
            <td>
                <a class="link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_potensi_uttp ?? '') }}, 'Potensi UTTP')">
                    File<i class="mdi mdi-file-pdf"></i>
                </a>
            </td>
            <td>Potensi UTTP <strong class="text-info">(file: pdf | max: 2mb)</strong></td>
            <td><input wire:model="request.file_potensi_uttp" type="file" accept=".pdf" class="form-control" /></td>
            <td>
                <a class="custom-file-label fw-800">
                    <i class="mdi mdi-file-document-outline link-info">download</i>
                </a>
            </td>
        </tr>
    </tbody>
</table>
