<div class="col-md-12">
    <div class="d-flex justify-content-end bg-light ">
        <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">

            <li class="list-inline-item">
                <span class="badge bg-primary-subtle text-primary">
                    <a class="align-middle minimize-card text-primary" data-bs-toggle="collapse" href="#collapseExample100"
                        role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <i class="mdi mdi-plus align-middle plus"><span
                                style="font-style: normal ; font-size: 14px">Maximize Form</span></i>
                        <i class="mdi mdi-minus align-middle minus"><span
                                style="font-style: normal ; font-size: 14px">Minimize Form</span></i>
                    </a>
                </span>
            </li>

        </ul>
    </div>
    <div class="card-header bg-light">
        <h4 class="text-center">Form Pengajuan Data Riwayat Pendidikan</h4>
    </div>

    <div class="card-body d-flex justify-content-center">
        <form wire:submit.prevent="store" id="collapseExample100">

            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="PeriodeUkom" class="form-label">
                            <span class="text-danger fw-bold">*</span> Periode UKom
                        </label>
                        <input wire:model="request.ukom.periode"
                            class="form-control @error('request.ukom.periode') is-invalid @enderror" type="month">
                        @error('request.ukom.periode')
                            <span class="invalid-feedback">
                            </span>
                        @enderror
                    </div>
                    {{-- <input wire:model='request.nip' hidden> --}}
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="JenisKompetensi" class="form-label">
                            <span class="text-danger fw-bold">*</span> Jenis Kompetensi
                        </label>
                        <select wire:model="request.ukom.jenis"
                            class="form-select mb-3 @error('request.ukom.jenis') is-invalid @enderror"
                            aria-label="JenisKompetensi" id="JenisKompetensi">
                            <option value="" selected>Pilih Kompetensi</option>
                            <option value="Kenaikan Jenjang">Kenaikan Jenjang </option>
                            <option value="Perpindahan Jabatan">Perpindahan Jabatan</option>
                            <option value="Promosi">Promosi</option>
                        </select>
                        @error('request.ukom.jenis')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.ukom.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!--end col-->
                <div class="card-title">
                    <h5 class="text-center font-14 mt-4">Nilai Kompetensi Manejerial dan Sosial Kultural</h5>
                    <hr>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiIntegritas" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Integritas
                        </label>
                        <input wire:model="request.mansoskul.integritas" type="text"
                            class="form-control @error('request.mansoskul.integritas') is-invalid @enderror"
                            id="NilaiIntegritas" placeholder="Masukkan Integritas ">
                        @error('request.mansoskul.integritas')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiKerjasama" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Kerjasama
                        </label>
                        <input wire:model="request.mansoskul.kerjasama" type="text"
                            class="form-control @error('request.mansoskul.kerjasama') is-invalid @enderror"
                            id="NilaiKerjasama" placeholder="Masukkan Kerjasama ">
                        @error('request.mansoskul.kerjasama')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiKomunikasi" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Komunikasi
                        </label>
                        <input wire:model="request.mansoskul.komunikasi" type="text"
                            class="form-control @error('request.mansoskul.komunikasi') is-invalid @enderror"
                            id="NilaiKomunikasi" placeholder="Masukkan Komunikasi ">
                        @error('request.mansoskul.komunikasi')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiOrientasiHasil" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Orientasi Hasil
                        </label>
                        <input wire:model="request.mansoskul.orientasi_hasil" type="text"
                            class="form-control @error('request.mansoskul.orientasi_hasil') is-invalid @enderror"
                            id="NilaiOrientasiHasil" placeholder="Masukkan Orientasi Hasil ">
                        @error('request.mansoskul.orientasi_hasil')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiPelayananPublic" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Pelayanan Public
                        </label>
                        <input wire:model="request.mansoskul.pelayanan_publik" type="text"
                            class="form-control @error('request.mansoskul.pelayanan_publik') is-invalid @enderror"
                            id="NilaiPelayananPublic" placeholder="Masukkan Layanan Public ">
                        @error('request.mansoskul.pelayanan_publik')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiPDOL" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Pengembangan Diri Orang Lain
                        </label>
                        <input wire:model="request.mansoskul.pengembangan_diri_orang_lain" type="text"
                            class="form-control @error('request.mansoskul.pengembangan_diri_orang_lain') is-invalid @enderror"
                            id="NilaiPDOL" placeholder="0">
                        @error('request.mansoskul.pengembangan_diri_orang_lain')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiPengelolahPerubahan" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Pengelolah Perubahan
                        </label>
                        <input wire:model="request.mansoskul.mengelola_perubahan" type="text"
                            class="form-control @error('request.mansoskul.mengelola_perubahan') is-invalid @enderror"
                            id="NilaiPengelolahPerubahan" placeholder="Masukkan Pengelolah Perubahan ">
                        @error('request.mansoskul.mengelola_perubahan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiPengambilKeputusan" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Pengambilan Keputusan
                        </label>
                        <input wire:model="request.mansoskul.pengambilan_keputusan" type="text"
                            class="form-control @error('request.mansoskul.pengambilan_keputusan') is-invalid @enderror"
                            id="NilaiPengambilKeputusan" placeholder="0">
                        @error('request.mansoskul.pengambilan_keputusan')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="NilaiPerekatBangsa" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Perekat Bangsa
                        </label>
                        <input wire:model="request.mansoskul.perekat_bangsa" type="text"
                            class="form-control @error('request.mansoskul.perekat_bangsa') is-invalid @enderror"
                            id="NilaiPerekatBangsa" placeholder="0">
                        @error('request.mansoskul.perekat_bangsa')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="NilaiJPM" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai JPM
                        </label>
                        <input wire:model="request.mansoskul.jpm" type="text"
                            class="form-control @error('request.mansoskul.jpm') is-invalid @enderror" id="NilaiJPM"
                            placeholder="0">
                        @error('request.mansoskul.jpm')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.mansoskul.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="card-title">
                    <h5 class="text-center font-14 mt-4">Nilai Kompetensi Teknis</h5>
                    <hr>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="NilaiCAT" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai CAT
                        </label>
                        <input wire:model="request.teknis.cat" type="text"
                            class="form-control @error('request.teknis.cat') is-invalid @enderror" id="NilaiCAT"
                            placeholder="Masukkan CAT ">
                        @error('request.teknis.cat')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.teknis. ', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="NilaiWawancara" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Wawancara
                        </label>
                        <input wire:model="request.teknis.wawancara" type="text"
                            class="form-control @error('request.teknis.wawancara') is-invalid @enderror"
                            id="NilaiWawancara" placeholder="0">
                        @error('request.teknis.wawancara')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.teknis. ', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="NilaiPraktik" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Praktik
                        </label>
                        <input wire:model="request.teknis.praktik" type="text"
                            class="form-control @error('request.teknis.praktik') is-invalid @enderror"
                            id="NilaiPraktik" placeholder="0">
                        @error('request.teknis.praktik')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.teknis. ', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="NilaiMakala" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Makala
                        </label>
                        <input wire:model="request.teknis.makala" type="text"
                            class="form-control @error('request.teknis.makala') is-invalid @enderror"
                            id="NilaiMakala" placeholder="0">
                        @error('request.teknis.makala')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.teknis. ', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="NilaiBobot" class="form-label">
                            <span class="text-danger fw-bold">*</span>Nilai Bobot
                        </label>
                        <input wire:model="request.teknis.nilai_bobot" type="text"
                            class="form-control @error('request.teknis.nilai_bobot') is-invalid @enderror"
                            id="NilaiBobot" placeholder="0">
                        @error('request.teknis.nilai_bobot')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.teknis. ', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="NilaiAkhir" class="form-label">
                            <span class="text-danger fw-bold">*</span> Nilai Akhir
                        </label>
                        <input wire:model="request.ukom.nilai_akhir" type="text"
                            class="form-control @error('request.ukom.nilai_akhir') is-invalid @enderror"
                            id="NilaiAkhir" placeholder="Nilai Akhir">
                        @error('request.ukom.nilai_akhir')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.ukom.', '', $message) }}</strong>
                            </span>
                        @enderror
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
    </div>
    <!-- Striped Rows -->
    <div class="col-lg-12">
        <div class="d-flex justify-content-end bg-light ">
            <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                <li class="list-inline-item">
                    <span class="badge bg-primary-subtle text-primary">
                        <a class="align-middle minimize-card text-primary" data-bs-toggle="collapse" href="#tablex"
                            role="button" aria-expanded="false" aria-controls="collapseExample2">
                            <i class="mdi mdi-plus align-middle plus"><span
                                    style="font-style: normal ; font-size: 14px">Maximize Form</span></i>
                            <i class="mdi mdi-minus align-middle minus"><span
                                    style="font-style: normal ; font-size: 14px">Minimize Form</span></i>
                        </a>
                    </span>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center mb-0">Data Riwayat UKom</h4>
            </div>
            <div class="card-body" id="tablex">
                @if (session()->get('status') == 1)
                    <div class="alert alert-primary" role="alert">
                        <H4> Data UKOM Riwayat UKOM DiPerbaharui</H4>
                    </div>
                @endif
                <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
                    <thead class="bg-light  ">
                        <tr>
                            <th>No</th>
                            <th>Periode UKom</th>
                            <th>Jenis Kompentensi</th>
                            <th>Status Verifikasi</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($ukomList))
                            @foreach ($ukomList as $index => $ukom)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <th>{{ $ukom->periode }}</th>
                                    <th>{{ $ukom->jenis }}</th>
                                    <td>{{ $ukom->task_status }}</td>
                                    <td>Comment</td>
                                    <td>Action</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('contentChanged', event => {
            initTable();
        });
    </script>
</div>
