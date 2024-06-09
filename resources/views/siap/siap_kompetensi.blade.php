<div class="col-md-12">
    <form method="POST" action="{{ route('/siap/kompetensi/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="NamaKompetensi" class="form-label">
                        <span class="text-danger fw-bold">*</span> Nama Kompetensi
                    </label>
                    <input name="name" class="form-control" placeholder="Nama Kompetensi">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="KategoriKompetensi" class="form-label">
                        <span class="text-danger fw-bold">*</span> Kategori Pengembangan
                    </label>
                    <select name="kategori" class="form-select mb-3" aria-label="KategoriKompetensi"
                        id="KategoriKompetensi">
                        <option value="" selected>Pilih Kategori Pengembagan</option>
                        <option value="Pelatihan Fungsional">Pelatihan Fungsional</option>
                        <option value="Pelatihan Teknis">Pelatihan Teknis</option>
                        <option value="Coaching/Mentoring">Coaching/Mentoring</option>
                        <option value="Penugasan">Penugasan</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalMulai" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Mulai
                    </label>
                    <input name="tgl_mulai" type="date" data-provider="flatpickr" class="form-control"
                        id="TanggalMulai" placeholder="Masukkan Tanggal Mulai">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalSelesai" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Selesai
                    </label>
                    <input name="tgl_selesai" type="date" data-provider="flatpickr" class="form-control"
                        id="TanggalSelesai" placeholder="Masukkan Tanggal Selesai">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="TanggalSertifikat" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Sertifikat
                    </label>
                    <input name="tgl_sertifikat" type="date" data-provider="flatpickr" class="form-control"
                        id="TanggalSertifikat" placeholder="Masukkan Tanggal Sertifikat">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileSertifikat" class="form-label">
                        <span class="text-danger fw-bold">*</span> File Serifikat
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_sertifikat" type="file" accept=".pdf" class="form-control"
                        id="FileSertifikat" />
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
    <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kompetensi</th>
                <th>Kategori Pengembangan</th>
                <th>File Sertifikat</th>
                <th>Status</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($userKompetensiList))
                @foreach ($userKompetensiList as $index => $kompetensi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kompetensi->name }}</td>
                        <td>{{ $kompetensi->kategori }}</td>
                        <td>
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($kompetensi->file_sertifikat) }}, 'Sertifikat')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td>
                            @if ($kompetensi->task_status == 'APPROVE')
                                <span class="badge bg-success">
                                    diterima
                                </span>
                            @elseif($kompetensi->task_status == 'REJECT')
                                <span class="badge bg-danger">
                                    ditolak
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    menunggu verifikasi
                                </span>
                            @endif
                        </td>
                        <td>{{ $kompetensi->comment ?? '-' }}</td>
                        <td>
                            <duv class="btn-group">
                                <form method="POST"
                                    action="{{ route('/siap/kompetensi/delete', ['id' => $kompetensi->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">
                                        Hapus <i class=" las la-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('/siap/kompetensi/detail', ['id' => $kompetensi->id]) }}"
                                    class="btn btn-sm btn-soft-info">
                                    Ubah <i class=" las la-trash"></i>
                                </a>
                            </duv>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
