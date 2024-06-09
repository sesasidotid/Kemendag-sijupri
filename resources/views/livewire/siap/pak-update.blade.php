<div>
    <h4 class="text-center">Form Penilaian Kinerja (Performance Review)</h4>
    <form wire:submit.prevent="store" id="kinerja">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="Periode" class="form-label">
                        Penilaian Tahunan/Periodik
                    </label>
                    <select wire:model="request.periode"
                        class="form-select mb-3 @error('request.periode') is-invalid @enderror" aria-label="Periode"
                        id="Pangkat">
                        <option selected>Pilih Tahunan/Periodik</option>
                        <option value="1">Periodik</option>
                        <option value="2">Tahunan</option>
                    </select>
                    @error('request.periode')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalMulaiHitungPenilaian" class="form-label">
                        Tanggal Mulai Hitung Penilaian
                    </label>
                    <input wire:model="request.tgl_mulai" type="date" data-provider="flatpickr"
                        class="form-control @error('request.tgl_mulai') is-invalid @enderror"
                        id="TanggalMulaiHitungPenilaian">
                    @error('request.tgl_mulai')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TanggalSelesaiHitungPenilaian" class="form-label">
                        Tanggal Selesai Hitung Penilaian
                    </label>
                    <input wire:model="request.tgl_selesai" type="date" data-provider="flatpickr"
                        class="form-control @error('request.tgl_selesai') is-invalid @enderror"
                        id="TanggalSelesaiHitungPenilaian">
                    @error('request.tgl_selesai')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="NilaiKinerja" class="form-label">
                        Rating Hasil Kinerja
                    </label>
                    <select wire:model="request.nilai_kinerja"
                        class="form-select mb-3 @error('request.nilai_kinerja') is-invalid @enderror"
                        aria-label="Periode" id="Pangkat">
                        <option selected>Pilih Rating Hasil Kinerja</option>
                        <option value="Di Atas Ekspektasi">Di Atas Ekspektasi</option>
                        <option value="Sesuai Ekspektasi">Sesuai Ekspektasi</option>
                        <option value="Di Bawah Ekspektasi">Di Bawah Ekspektasi</option>
                    </select>
                    @error('request.nilai_kinerja')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="NilaiPerilaku" class="form-label">
                        Rating Perilaku Kerja
                    </label>
                    <select wire:model="request.nilai_perilaku"
                        class="form-select mb-3 @error('request.nilai_perilaku') is-invalid @enderror"
                        aria-label="Periode" id="Pangkat">
                        <option selected>Pilih Perilaku Kerja</option>
                        <option value="Di Atas Ekspektasi">Di Atas Ekspektasi</option>
                        <option value="Sesuai Ekspektasi">Sesuai Ekspektasi</option>
                        <option value="Di Bawah Ekspektasi">Di Bawah Ekspektasi</option>
                    </select>
                    @error('request.nilai_perilaku')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="RatingPredikat" class="form-label">
                        Predikat Kinerja
                    </label>
                    <select wire:model="request.predikat"
                        class="form-select mb-3 @error('request.predikat') is-invalid @enderror"
                        aria-label="RatingPredikat" id="Pangkat">
                        <option selected>Pilih Predikat Kinerja</option>
                        <option value="Sangat baik">Sangat baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                        <option value="Kurang">Kurang</option>
                        <option value="Sangat kurang">Sangat kurang</option>
                    </select>
                    @error('request.predikat')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="AngkaKredit" class="form-label">
                        Angka Kredit
                    </label>
                    <input wire:model="request.angka_kredit" type="number"
                        class="form-control @error('request.angka_kredit') is-invalid @enderror" id="AngkaKredit"
                        placeholder="Masukkan Angka Kredit">
                    @error('request.angka_kredit')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="HasilEvaluasiKinerja" class="form-label">
                        Dokumen Hasil Evaluasi Kinerja
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_hasil_eval" type="file" accept=".pdf"
                        class="form-control @error('request.file_hasil_eval') is-invalid @enderror"
                        id="HasilEvaluasiKinerja" />
                    @error('request.file_hasil_eval')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                    <div wire:loading wire:target="request.file_hasil_eval">
                        <p class="mt-1">Uploading... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="KonversiPredikatKinerja" class="form-label">
                        Dokumen Konversi Predikat Kinerja
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_dok_konversi" type="file" accept=".pdf"
                        class="form-control @error('request.file_dok_konversi') is-invalid @enderror"
                        id="KonversiPredikatKinerja" />
                    @error('request.file_dok_konversi')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                    <div wire:loading wire:target="request.file_dok_konversi">
                        <p class="mt-1">Uploading... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="AkumulasiAngkaKredit" class="form-label">
                        Dokumen Akumulasi Angka Kredit
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_akumulasi_ak" type="file" accept=".pdf"
                        class="form-control @error('request.file_akumulasi_ak') is-invalid @enderror"
                        id="AkumulasiAngkaKredit" />
                    @error('request.file_akumulasi_ak')
                        <span class="invalid-feedback">
                            <strong>{{ str_replace('request.', '', $message) }}</strong>
                        </span>
                    @enderror
                    <div wire:loading wire:target="request.file_akumulasi_ak">
                        <p class="mt-1">Uploading... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="DokumenAngkaKredit" class="form-label">
                        Dokumen Penetapan Angka Kredit
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input wire:model="request.file_doc_ak" type="file" accept=".pdf" class="form-control"
                        id="DokumenAngkaKredit" />
                    <div wire:loading wire:target="request.file_doc_ak">
                        <p class="mt-1">Uploading... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                        </p>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                    <button type="submit" class="btn btn-secondary">Simpan</button>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
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
                                onclick="previewModal({{ json_encode($jabatan->file_doc_ak) }}, 'Dokumen Angka Kredit')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($jabatan->file_dok_konversi) }}, 'Dokumen Konversi Predikat Kinerja')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($jabatan->file_hasil_eval) }}, 'Hasil Evaluasi')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($jabatan->file_akumulasi_ak) }}, 'Akumulasi Angka Kredit')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col">{{ $jabatan->task_status ?? 'menunggu verifikasi' }}</td>
                        <td scope="col">{{ $jabatan->comment ?? '' }}</td>
                        <td scope="col" class="p-1">
                            <a wire:click="delete({{ $jabatan->id }})" class="link-danger">
                                Hapus <i class=" las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <script>
        window.addEventListener('contentChanged', event => {
            initTable();
        });
        Livewire.on('fileUploading', () => {
            console.log('File uploading...');
        });
        Livewire.on('fileUploaded', () => {
            console.log('File uploaded!');
        });
    </script>
</div>
