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
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userSertifikasiList as $index => $sertifikasi)
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
                <td>
                    @if ($sertifikasi->task_status == 'APPROVE')
                        <span class="badge bg-success">
                            diterima
                        </span>
                    @else
                        <span class="badge bg-warning">
                            menunggu verifikasi
                        </span>
                    @endif
                </td>
                <td class="text-center">
                    @if ($sertifikasi->task_status != 'APPROVE')
                        <div class="btn-group">
                            <form
                                action="{{ route('/user/user_jf/verifikasi/user_sertifikat', ['id' => $sertifikasi->id]) }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="btn btn-sm btn-soft-success waves-effect btn-sm waves-light" value="APPROVE"
                                    name="task_status">
                                    <i class=""></i>Terima
                                </button>
                            </form>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#tolak_sertifikasi{{ $sertifikasi->id }}"
                                class="btn btn-sm btn-soft-danger waves-effect btn-sm waves-light">
                                <i class=""></i>Tolak
                            </button>
                        </div>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <div class="modal fade" id="tolak_sertifikasi{{ $sertifikasi->id }}" tabindex="-1"
                aria-labelledby="exampleModalgridLabel" aria-modal="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger ">
                            <h5 class="modal-title text-white" id="exampleModalgridLabel">
                                Anda Menolak Data Riwayat Ini
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Silahkan masukan komen pada field dibawah!</p>
                            <form method="POST"
                                action="{{ route('/user/user_jf/verifikasi/user_sertifikat', ['id' => $sertifikasi->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div>
                                            <input type="text" hidden value="{{ $sertifikasi->id }}" name="id">
                                            <input type="text" hidden value="REJECT" name="task_status">
                                            <label for="exampleFormControlTextarea5" class="form-label">Komen</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" name="comment"></textarea>
                                        </div>
                                        <input type="text" hidden value="id_riwayat">
                                    </div> <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-sm btn-soft-light text-dark"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-sm btn-soft-danger">Tolak</button>
                                        </div>
                                    </div> <!--end col-->
                                </div> <!--end row-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>
