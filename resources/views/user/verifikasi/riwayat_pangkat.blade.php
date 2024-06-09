<table class="main-table table nowrap align-middle" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Pangkat</th>
            <th>SK Pangkat</th>
            <th>TMT</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userPangkatList as $index => $pangkat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pangkat->pangkat->description }}/{{ $pangkat->pangkat->name }}</td>
                <td>
                    <a class="link-info" href="javascript:void(0);"
                        onclick="previewModal({{ json_encode($pangkat->file_sk_pangkat ?? '-') }}, 'SK Pangkat')">
                        Lihat <i class=" las la-eye"></i>
                    </a>
                </td>
                <td>{{ $pangkat->tmt }}</td>
                <td>
                    @if ($pangkat->task_status == 'APPROVE')
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
                    @if ($pangkat->task_status != 'APPROVE')
                        <div class="btn-group">
                            <form action="{{ route('/user/user_jf/verifikasi/user_pangkat', ['id' => $pangkat->id]) }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="btn btn-sm btn-soft-success waves-effect btn-sm waves-light" value="APPROVE"
                                    name="task_status">
                                    <i class=""></i>Terima
                                </button>
                            </form>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#tolak_pangkat{{ $pangkat->id }}"
                                class="btn btn-sm btn-soft-danger waves-effect btn-sm waves-light">
                                <i class=""></i>Tolak
                            </button>
                        </div>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <div class="modal fade" id="tolak_pangkat{{ $pangkat->id }}" tabindex="-1" aria-labelledby="exampleModalgridLabel"
                aria-modal="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger ">
                            <h5 class="modal-title text-white" id="exampleModalgridLabel">
                                Anda Menolak Data Riwayat Ini
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Silahkan masukan komen pada field dibawah!</p>
                            <form method="POST"
                                action="{{ route('/user/user_jf/verifikasi/user_pangkat', ['id' => $pangkat->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <div>
                                            <input type="text" hidden value="{{ $pangkat->id }}" name="id">
                                            <input type="text" hidden value="REJECT" name="task_status">
                                            <label for="exampleFormControlTextarea5" class="form-label">Komen</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" name="comment"></textarea>
                                        </div>
                                        <input type="text" hidden value="id_riwayat">
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-sm btn-soft-light text-dark"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-sm btn-soft-danger">Tolak</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>
