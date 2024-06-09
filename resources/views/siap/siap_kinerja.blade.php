<div>
    <form method="POST" action="{{ route('/siap/kinerja/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="Periode" class="form-label">
                        Penilaian Tahunan/Periodik
                    </label>
                    <select name="periode" class="form-select mb-3" aria-label="Periode" id="Pangkat">
                        <option selected>Pilih Tahunan/Periodik</option>
                        <option value="1">Periodik</option>
                        <option value="2">Tahunan</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalMulaiHitungPenilaian" class="form-label">
                        Tanggal Mulai Hitung Penilaian
                    </label>
                    <input name="tgl_mulai" type="date" data-provider="flatpickr" class="form-control"
                        id="TanggalMulaiHitungPenilaian">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalSelesaiHitungPenilaian" class="form-label">
                        Tanggal Selesai Hitung Penilaian
                    </label>
                    <input name="tgl_selesai" type="date" data-provider="flatpickr" class="form-control"
                        id="TanggalSelesaiHitungPenilaian">
                    @error('request.tgl_selesai')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="NilaiKinerja" class="form-label">
                        Rating Hasil Kinerja
                    </label>
                    <select name="nilai_kinerja" class="form-select mb-3" aria-label="Periode" id="Pangkat">
                        <option selected>Pilih Rating Hasil Kinerja</option>
                        <option value="Di Atas Ekspektasi">Di Atas Ekspektasi</option>
                        <option value="Sesuai Ekspektasi">Sesuai Ekspektasi</option>
                        <option value="Di Bawah Ekspektasi">Di Bawah Ekspektasi</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="NilaiPerilaku" class="form-label">
                        Rating Perilaku Kerja
                    </label>
                    <select name="nilai_perilaku" class="form-select mb-3" aria-label="Periode" id="Pangkat">
                        <option selected>Pilih Perilaku Kerja</option>
                        <option value="Di Atas Ekspektasi">Di Atas Ekspektasi</option>
                        <option value="Sesuai Ekspektasi">Sesuai Ekspektasi</option>
                        <option value="Di Bawah Ekspektasi">Di Bawah Ekspektasi</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="RatingPredikat" class="form-label">
                        Predikat Kinerja
                    </label>
                    <select name="predikat" class="form-select mb-3" aria-label="RatingPredikat" id="Pangkat">
                        <option selected>Pilih Predikat Kinerja</option>
                        <option value="Sangat baik">Sangat baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                        <option value="Kurang">Kurang</option>
                        <option value="Sangat kurang">Sangat kurang</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="AngkaKredit" class="form-label">
                        Angka Kredit
                    </label>
                    <input name="angka_kredit" type="number" class="form-control" id="AngkaKredit"
                        placeholder="Masukkan Angka Kredit">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="HasilEvaluasiKinerja" class="form-label">
                        Dokumen Hasil Evaluasi Kinerja
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_hasil_eval" type="file" accept=".pdf" class="form-control"
                        id="HasilEvaluasiKinerja" />
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="KonversiPredikatKinerja" class="form-label">
                        Dokumen Konversi Predikat Kinerja
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_dok_konversi" type="file" accept=".pdf" class="form-control"
                        id="KonversiPredikatKinerja" />
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="AkumulasiAngkaKredit" class="form-label">
                        Dokumen Akumulasi Angka Kredit
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_akumulasi_ak" type="file" accept=".pdf" class="form-control"
                        id="AkumulasiAngkaKredit" />
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="DokumenAngkaKredit" class="form-label">
                        Dokumen Penetapan Angka Kredit
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_doc_ak" type="file" accept=".pdf" class="form-control"
                        id="DokumenAngkaKredit" />
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
    <table class="main-table table table-bordered nowrap align-middle w-100">
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
                <th scope="col">Dokumen Angka Kredit</th>
                <th scope="col">Dokumen Konversi Predikat Kinerja</th>
                <th scope="col">Hail Evaluasi</th>
                <th scope="col">Akumulasi Angka Kredit</th>
                <th scope="col">Status</th>
                <th scope="col">Comment</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($userPakList))
                @foreach ($userPakList as $index => $kinerja)
                    <tr>
                        <td scope="col">{{ $index + 1 }}</td>
                        <td scope="col">{{ $kinerja->periode == 1 ? 'Periodik' : 'Tahunan' }}</td>
                        <td scope="col">{{ $kinerja->tgl_mulai }}</td>
                        <td scope="col">{{ $kinerja->tgl_selesai }}</td>
                        <td scope="col">{{ $kinerja->nilai_kinerja }}</td>
                        <td scope="col">{{ $kinerja->nilai_perilaku }}</td>
                        <td scope="col">{{ $kinerja->predikat }}</td>
                        <td scope="col">{{ $kinerja->angka_kredit }}</td>
                        <td scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($kinerja->file_doc_ak) }}, 'Dokumen Angka Kredit')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($kinerja->file_dok_konversi) }}, 'Dokumen Konversi Predikat Kinerja')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($kinerja->file_hasil_eval) }}, 'Hasil Evaluasi')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($kinerja->file_akumulasi_ak) }}, 'Akumulasi Angka Kredit')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td>
                            @if ($kinerja->task_status == 'APPROVE')
                                <span class="badge bg-success">
                                    diterima
                                </span>
                            @elseif($kinerja->task_status == 'REJECT')
                                <span class="badge bg-danger">
                                    ditolak
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    menunggu verifikasi
                                </span>
                            @endif
                        </td>
                        <td scope="col">{{ $kinerja->comment ?? '-' }}</td>
                        <td scope="col" class="p-1">
                            <div class="btn-group">
                                <form method="POST"
                                    action="{{ route('/siap/kinerja/delete', ['id' => $kinerja->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">
                                        Hapus <i class=" las la-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('/siap/kinerja/detail', ['id' => $kinerja->id]) }}"
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
