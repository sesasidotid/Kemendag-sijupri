<table class="table table-striped">
    <thead>
        <tr>
            <th>status</th>
            <th>Nama</th>
            <th>File</th>
            <th>verifikasi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                @if ($formasiDocument->status_surat_pengajuan_abk)
                    <span style="font-size: 0.75rem" class="badge bg-success">Sudeh dirverifikasi</span>
                @else
                    <span style="font-size: 0.75rem" class="badge bg-danger">Belum dirverifikasi</span>
                @endif
            </td>
            <td>Surat Pengajuan ABK</td>
            <td>
                <a class="link link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_surat_pengajuan_abk ?? '') }}, 'Surat Pengajuan ABK')">
                    Lihat <i class=" las la-eye"></i>
                </a>
            </td>
            <td>
                @if ($formasiDocument->status_surat_pengajuan_abk)
                    <button wire:click="batalVerifikasiDokumen('status_surat_pengajuan_abk')" class="btn btn-danger">
                        Batal
                    </button>
                @else
                    <button wire:click="verifikasiDokumen('status_surat_pengajuan_abk')" class="btn btn-success">
                        verifikasi
                    </button>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                @if ($formasiDocument->status_struktur_organisasi)
                    <span style="font-size: 0.75rem" class="badge bg-success">Sudeh dirverifikasi</span>
                @else
                    <span style="font-size: 0.75rem" class="badge bg-danger">Belum dirverifikasi</span>
                @endif
            </td>
            <td>Struktur Organisasi</td>
            <td>
                <a class="link link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_struktur_organisasi ?? '') }}, 'Struktur Organisasi')">
                    Lihat <i class=" las la-eye"></i>
                </a>
            </td>
            <td>
                @if ($formasiDocument->status_struktur_organisasi)
                    <button wire:click="batalVerifikasiDokumen('status_struktur_organisasi')" class="btn btn-danger">
                        Batal
                    </button>
                @else
                    <button wire:click="verifikasiDokumen('status_struktur_organisasi')" class="btn btn-success">
                        verifikasi
                    </button>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                @if ($formasiDocument->status_daftar_susunan_pegawai)
                    <span style="font-size: 0.75rem" class="badge bg-success">Sudeh dirverifikasi</span>
                @else
                    <span style="font-size: 0.75rem" class="badge bg-danger">Belum dirverifikasi</span>
                @endif
            </td>
            <td>Daftar Susunan Pegawai</td>
            <td>
                <a class="link link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_daftar_susunan_pegawai ?? '') }}, 'Daftar Susunan Pegawai')">
                    Lihat <i class=" las la-eye"></i>
                </a>
            </td>
            <td>
                @if ($formasiDocument->status_daftar_susunan_pegawai)
                    <button wire:click="batalVerifikasiDokumen('status_daftar_susunan_pegawai')" class="btn btn-danger">
                        Batal
                    </button>
                @else
                    <button wire:click="verifikasiDokumen('status_daftar_susunan_pegawai')" class="btn btn-success">
                        verifikasi
                    </button>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                @if ($formasiDocument->status_rencana_pemenuhan_kebutuhan_pegawai)
                    <span style="font-size: 0.75rem" class="badge bg-success">Sudeh dirverifikasi</span>
                @else
                    <span style="font-size: 0.75rem" class="badge bg-danger">Belum dirverifikasi</span>
                @endif
            </td>
            <td>Rencana Pemenuhan Kebutuhan Pegawai</td>
            <td>
                <a class="link link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_rencana_pemenuhan_kebutuhan_pegawai ?? '') }}, 'Rencana Pemenuhan Kebutuhan Pegawai')">
                    Lihat <i class=" las la-eye"></i>
                </a>
            </td>
            <td>
                @if ($formasiDocument->status_rencana_pemenuhan_kebutuhan_pegawai)
                    <button wire:click="batalVerifikasiDokumen('status_rencana_pemenuhan_kebutuhan_pegawai')"
                        class="btn btn-danger">
                        Batal
                    </button>
                @else
                    <button wire:click="verifikasiDokumen('status_rencana_pemenuhan_kebutuhan_pegawai')"
                        class="btn btn-success">
                        verifikasi
                    </button>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                @if ($formasiDocument->status_potensi_uttp)
                    <span style="font-size: 0.75rem" class="badge bg-success">Sudeh dirverifikasi</span>
                @else
                    <span style="font-size: 0.75rem" class="badge bg-danger">Belum dirverifikasi</span>
                @endif
            </td>
            <td>Potensi UTTP</td>
            <td>
                <a class="link link-info" href="javascript:void(0);"
                    onclick="previewModal({{ json_encode($formasiDocument->file_potensi_uttp ?? '') }}, 'Potensi UTTP')">
                    Lihat <i class=" las la-eye"></i>
                </a>
            </td>
            <td>
                @if ($formasiDocument->status_potensi_uttp)
                    <button wire:click="batalVerifikasiDokumen('status_potensi_uttp')" class="btn btn-danger">
                        Batal
                    </button>
                @else
                    <button wire:click="verifikasiDokumen('status_potensi_uttp')" class="btn btn-success">
                        verifikasi
                    </button>
                @endif
            </td>
        </tr>
    </tbody>
</table>
