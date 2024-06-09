<div class="col-md-12">
    <form method="POST" action="{{ route('/siap/sertifikasi/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="Kategori" class="form-label">
                        <span class="text-danger fw-bold">*</span> Kategori Sertifikasi
                    </label>
                    <select name="kategori" class="form-select mb-3" aria-label="Kategori" id="kategori">
                        <option selected value="Pegawai Berhak">Pegawai Berhak</option>
                        <option value="Penyidik Pegawai Negri Sipil(PPNS)">Penyidik Pegawai Negri Sipil (PPNS)
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="NoSK" class="form-label">
                        <span class="text-danger fw-bold">*</span> No. SK
                    </label>
                    <input name="nomor_sk" type="text" class="form-control" id="NoSK"
                        placeholder="Masukkan No. SK ">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalSK" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal SK
                    </label>
                    <input name="tanggal_sk" type="date" data-provider="flatpickr" class="form-control"
                        id="TanggalSK" placeholder="Masukkan Penugasan">
                </div>
            </div>
            <div class="toggle-kategori col-lg-12">
                <div class="mb-3">
                    <label for="WilayahKerja" class="form-label">
                        <span class="text-danger fw-bold">*</span> Wilayah Kerja
                    </label>
                    <input name="wilayah_kerja" type="text" class="form-control" id="WilayahKerja"
                        placeholder="Masukkan Penugasan">
                </div>
            </div>
            <div class="toggle-kategori col-lg-6">
                <div class="mb-3">
                    <label for="TglMulai" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Berlaku Mulai
                    </label>
                    <input name="berlaku_mulai" type="date" data-provider="flatpickr" class="form-control"
                        id="TglMulai" placeholder="Masukkan Penugasan">
                </div>
            </div>
            <div class="toggle-kategori col-lg-6">
                <div class="mb-3">
                    <label for="TglSampai" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Berlaku Sampai
                    </label>
                    <input name="berlaku_sampai" type="date" data-provider="flatpickr" class="form-control"
                        id="TglSampai" placeholder="Masukkan Penugasan">
                </div>
            </div>
            <div class="toggle-kategori col-lg-12">
                <div class="mb-3">
                    <label for="UUKawalan" class="form-label">
                        <span class="text-danger fw-bold">*</span> UU yang di Kawal
                    </label>
                    <input name="uu_kawalan" type="text" class="form-control" id="UUKawalan"
                        placeholder="Masukkan Penugasan">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="SKPengangkatan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Dokumen SK Pengangkatan
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_doc_sk" type="file" accept=".pdf" class="form-control" id="SKPengangkatan"
                        placeholder="Masukkan Penugasan">
                </div>
            </div>
            <div class="toggle-kategori col-lg-12">
                <div class="mb-3">
                    <label for="TKPPPNS" class="form-label">
                        <span class="text-danger fw-bold">*</span> Kartu Tanda Pengenal PPNS
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_ktp_ppns" type="file" accept=".pdf" class="form-control" id="TKPPPNS"
                        placeholder="Masukkan Penugasan">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <table class="main-table table table-bordered nowrap align-middle" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori Sertifikasi</th>
                <th>No SK</th>
                <th>Tanggal SK</th>
                <th>Wilayah Kerja</th>
                <th>Tanggal Berlaku Mulai</th>
                <th>Tanggal Berlaku Sampai</th>
                <th>Dokument SK</th>
                <th>UU Kawalan</th>
                <th>Kartu Tanda Pengenal PPNS</th>
                <th>Status Verifikasi</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($userSertifikasiList))
                @foreach ($userSertifikasiList as $index => $sertifikasi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sertifikasi->kategori }}</td>
                        <td>{{ $sertifikasi->nomor_sk }}</td>
                        <td>{{ $sertifikasi->tanggal_sk }}</td>
                        <td>{{ $sertifikasi->wilayah_kerja ?? '' }}</td>
                        <td>{{ $sertifikasi->berlaku_mulai ?? '' }}</td>
                        <td>{{ $sertifikasi->berlaku_sampai ?? '' }}</td>
                        <td>{{ $sertifikasi->uu_kawalan }}</td>
                        <td class="text-center">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($sertifikasi->file_doc_sk) }}, 'Dokumen SK')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($sertifikasi->file_ktp_ppns) }}, 'KTP PPNS')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td>
                            @if ($sertifikasi->task_status == 'APPROVE')
                                <span class="badge bg-success">
                                    diterima
                                </span>
                            @elseif($sertifikasi->task_status == 'REJECT')
                                <span class="badge bg-danger">
                                    ditolak
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    menunggu verifikasi
                                </span>
                            @endif
                        </td>
                        <td scope="col" class="p-1 text-center">
                            {{ $sertifikasi->comment ?? '-' }}
                        </td>
                        <td>
                            <div class="btn-group">
                                <form method="POST"
                                    action="{{ route('/siap/sertifikasi/delete', ['id' => $sertifikasi->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">
                                        Hapus <i class=" las la-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('/siap/sertifikasi/detail', ['id' => $sertifikasi->id]) }}"
                                    class="btn btn-sm btn-soft-info">
                                    Ubah <i class=" las la-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@push('ext_footer')
    <script>
        $(document).ready(function() {
            $('.toggle-kategori').hide().prop('disabled', true);

            $('#kategori').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === "Pegawai Berhak") {
                    $('.toggle-kategori').hide().prop('disabled', true);
                } else {
                    $('.toggle-kategori').show().prop('disabled', false);
                }
            });
        });
    </script>
@endpush
