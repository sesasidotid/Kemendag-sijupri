<div>
    <form method="POST" action="{{ route('/siap/pangkat/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="TMT" class="form-label">
                        Terhitung Mulai Tanggal
                    </label>
                    <input name="tmt" type="date" data-provider="flatpickr" class="form-control" id="TMT"
                        placeholder="Masukkan TMT">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="Pangkat" class="form-label">
                        Pangkat
                    </label>
                    <select name="pangkat_id" class="form-select mb-3" aria-label="Pangkat" id="Pangkat">
                        <option selected>Pilih Pangkat/Golongan Ruang</option>
                        @if (isset($pangkatList))
                            @foreach ($pangkatList as $item)
                                <option value="{{ $item->id }}">{{ $item->description }}/{{ $item->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="FileSKPangkat" class="form-label">
                        File SK Pangkat
                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                    </label>
                    <input name="file_sk_pangkat" type="file" accept=".pdf" class="form-control"
                        id="FileSKPangkat" />
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
            <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">pangkat</th>
                <th scope="col">SK Pangkat</th>
                <th scope="col">Status</th>
                <th scope="col">Comment </th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($userPangkatList))
                @foreach ($userPangkatList as $index => $pangkat)
                    <tr>
                        <td scope="col">{{ $index + 1 }}</td>
                        <td scope="col">{{ $pangkat->pangkat->description }}/{{ $pangkat->pangkat->name }}</td>
                        <td class="text-center" scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($pangkat->file_sk_pangkat) }}, 'SK Pangkat')">
                                Lihat <i class=" las la-eye"></i>
                            </a>
                        </td>
                        <td>
                            @if ($pangkat->task_status == 'APPROVE')
                                <span class="badge bg-success">
                                    diterima
                                </span>
                            @elseif($pangkat->task_status == 'REJECT')
                                <span class="badge bg-danger">
                                    ditolak
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    menunggu verifikasi
                                </span>
                            @endif
                        </td>
                        <td scope="col" class="text-center">
                            {{ $pangkat->comment ?? '-' }}
                        </td>
                        <td scope="col" class="text-center">
                            <div class="btn-group">
                                <form method="POST"
                                    action="{{ route('/siap/pangkat/delete', ['id' => $pangkat->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">
                                        Hapus <i class=" las la-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('/siap/pangkat/detail', ['id' => $pangkat->id]) }}"
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
