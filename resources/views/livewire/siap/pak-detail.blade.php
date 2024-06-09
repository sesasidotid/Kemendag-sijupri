<div>
    <div class="row">
        <div class="card-title mt-2">
            <h4 class="text-center">Riwayat Kinerja</h4>
        </div>
        <div class="col-md-12" id="tableKinerja">
            <table class="main-table  table table-bordered nowrap align-middle w-100">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tahunan/Bulanan</th>
                        <th scope="col">Tanggal Mulai</th>
                        <th scope="col">Tanggal Selesai</th>
                        <th scope="col">Nilai Kinerja</th>
                        <th scope="col">Nilai Perilaku</th>
                        <th scope="col">Predikat</th>
                        <th scope="col">Angka Kredit</th>
                        <th scope="col">File Dokumen Angka Kredit</th>
                        <th scope="col">File Hail Evaluasi</th>
                        <th scope="col">File Akumulasi Angka Kredit</th>
                        <th scope="col">Action</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($userJabatanList))
                        @foreach ($userJabatanList as $index => $jabatan)
                            <tr>
                                <td scope="col">{{ $index + 1 }}</td>
                                <td scope="col">{{ $jabatan->periode == 1 ? 'Periodik' : 'Tahunan' }}</td>
                                <td scope="col">{{ $jabatan->tgl_mulai }}</td>
                                <td scope="col">{{ $jabatan->tgl_selesai }}</td>
                                <td scope="col">{{ $jabatan->nilai_kinerja }}</td>
                                <td scope="col">{{ $jabatan->nilai_perilaku }}</td>
                                <td scope="col">{{ $jabatan->predikat }}</td>
                                <td scope="col">{{ $jabatan->angka_kredit }}</td>
                                <td scope="col">
                                    <a class="link-info" href="javascript:void(0);"
                                        onclick="previewModal({{ json_encode($jabatan->file_doc_ak) }}, 'SK Jabatan')">
                                        Lihat
                                        <span class="mdi mdi-eye-circle-outline h4 text-info"></span>
                                    </a>
                                </td>
                                <td scope="col">
                                    <a class="link-info" href="javascript:void(0);"
                                        onclick="previewModal({{ json_encode($jabatan->file_hasil_eval) }}, 'SK Jabatan')">
                                        Lihat
                                        <span class="mdi mdi-eye-circle-outline h4 text-info"></span>
                                    </a>
                                </td>
                                <td scope="col">
                                    <a class="link-info" href="javascript:void(0);"
                                        onclick="previewModal({{ json_encode($jabatan->file_akumulasi_ak) }}, 'SK Jabatan')">
                                        Lihat
                                        <span class="mdi mdi-eye-circle-outline h4 text-info"></span>
                                    </a>
                                </td>
                                <td scope="col" class="p-1">
                                    <a class="link-danger ps-1 border-start">
                                        hapus<i class="mdi mdi-delete-circle-outline h4 text-danger"></i>
                                    </a>
                                </td>
                                <td scope="col">{{ $jabatan->task_status ?? 'menunggu verifikasi' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
