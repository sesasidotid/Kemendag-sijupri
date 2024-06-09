<div class="col-md-12">
    <form method="POST" action="{{ route('/siap/pendidikan/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="Pendidikan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tingkat Pendidikan
                    </label>
                    <select name="level" class="form-select mb-3" aria-label="Pendidikan" id="Pendidikan">
                        <option selected>Pilih Tingkat Pendidikan</option>
                        <option value="SMA">SLTA/SMK</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1/D4</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="InstansiPendidikan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Nama Institusi Pendidikan
                    </label>
                    <input name="instansi_pendidikan" type="text" class="form-control" id="InstansiPendidikan"
                        placeholder="Masukkan Nama Institusi Pendidikan ">
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="Jurusan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Jurusan/Program Studi
                    </label>
                    <input name="jurusan" type="text" class="form-control" id="Jurusan"
                        placeholder="Masukkan Jurusan/Program Studi">
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="InstansiPendidikan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tanggal Ijazah
                    </label>
                    <input name="bulan_kelulusan" type="date" data-provider="flatpickr" class="form-control"
                        id="InstansiPendidikan" placeholder="Masukkan Instansi Pendidikan">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileIjazah" class="form-label">
                        <span class="text-danger fw-bold">*</span> Tingkat Pendidikan File Ijazah
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_ijazah" type="file" accept=".pdf" class="form-control  border-bottom-1"
                        id="FileIjazah" />
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
    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pendidikan</th>
                <th>Instansi</th>
                <th>Jurusan</th>
                <th>File Ijazah</th>
                <th>Tanggal Ijazah</th>
                <th>Status</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="">
            @if (isset($userPendidikanList))
                @foreach ($userPendidikanList as $index => $pendidikan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pendidikan->level }}</td>
                        <td>{{ $pendidikan->instansi_pendidikan }}</td>
                        <td>{{ $pendidikan->jurusan }}</td>
                        <td class="text-center">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($pendidikan->file_ijazah) }}, 'Ijazah')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td>{{ $pendidikan->bulan_kelulusan }} </td>
                        <td>
                            @if ($pendidikan->task_status == 'APPROVE')
                                <span class="badge bg-success">
                                    diterima
                                </span>
                            @elseif($pendidikan->task_status == 'REJECT')
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
                            {{ $pendidikan->comment ?? '-' }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <form method="POST"
                                    action="{{ route('/siap/pendidikan/delete', ['id' => $pendidikan->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">
                                        Hapus <i class=" las la-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('/siap/pendidikan/detail', ['id' => $pendidikan->id]) }}"
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
