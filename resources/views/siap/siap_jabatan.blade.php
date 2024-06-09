<div class="col-md-12">
    <form method="POST" action="{{ route('/siap/jabatan/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="Jabatan" class="form-label">
                        <span class="text-danger fw-bold">*</span> Jabatan
                    </label>
                    <select name="jabatan_code" id="Jabatan" class="form-select" name="state">
                        @if (isset($jabatanList))
                            <div
                                style="position: absolute ;  display: none;
                        position: absolute;">
                                <option selected>Pilih Jabatan Fungsional Perdagangan</option>
                                @foreach ($jabatanList as $item)
                                    <option value="{{ $item->code }}">- {{ $item->name }}</option>
                                @endforeach
                            </div>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="Jenjang" class="form-label">
                        <span class="text-danger fw-bold">*</span> Jenjang
                    </label>
                    <select name="jenjang_code" class=" form-select" id="Jenjang">
                        <option selected>Pilih Jenjang</option>
                        @if (isset($jenjangList))
                            @foreach ($jenjangList as $item)
                                <option value="{{ $item->code }}">- {{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="TMT" class="form-label">
                        <span class="text-danger fw-bold">*</span> Terhitung Mulai Tanggal
                    </label>
                    <input name="tmt" type="date" data-provider="flatpickr" class="form-control" id="TMT"
                        placeholder="Masukkan TMT">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileSKJabatan" class="form-label">
                        <span class="text-danger fw-bold">*</span> File SK Jabatan
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_sk_jabatan" type="file" accept=".pdf" class="form-control"
                        id="FileSKJabatan" />
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
                <th scope="col">TMT</th>
                <th scope="col">Tipe Jabatan</th>
                <th scope="col">Jenjang</th>
                <th scope="col">Nama Jabatan</th>
                <th scope="col">SK Jabatan</th>
                <th scope="col">Tanggal Pengajuan</th>
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
                        <td scope="col">{{ $jabatan->tmt }}</td>
                        <td scope="col">{{ $jabatan->tipe_jabatan }}</td>
                        <td scope="col">{{ $jabatan->jenjang->name ?? '' }}</td>
                        <td scope="col">{{ $jabatan->name }}</td>
                        <td scope="col" class="text-center">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($jabatan->file_sk_jabatan) }}, 'SK Jabatan')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td scope="col" class="p-1">
                            {{ $jabatan->created_at }}
                        </td>
                        <td>
                            @if ($jabatan->task_status == 'APPROVE')
                                <span class="badge bg-success">
                                    diterima
                                </span>
                            @elseif($jabatan->task_status == 'REJECT')
                                <span class="badge bg-danger">
                                    ditolak
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    menunggu verifikasi
                                </span>
                            @endif
                        </td>
                        <td scope="col">{{ $jabatan->comment ?? '-' }}</td>
                        <td scope="col">
                            <div class="btn-group">
                                <form method="POST"
                                    action="{{ route('/siap/jabatan/delete', ['id' => $jabatan->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">
                                        Hapus <i class=" las la-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('/siap/jabatan/detail', ['id' => $jabatan->id]) }}"
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
