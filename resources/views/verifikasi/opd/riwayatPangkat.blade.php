@extends('layout.v_wrapper')
@section('title')
    Detail Riwayat Pangkat
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Riwayat Pangkat</h4>

                </div><!-- end card header -->
                <div class="card-body">
                    <table class="main-table table nowrap align-middle" style="width:100%">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pangkat</th>
                                <th>SK Pangkat</th>
                                <th>TMT</th>
                                <th>Tanggal Pengajuan</th>
                                <th class="text-center">Action Terima</th>
                                <th class="text-center">Action Tolak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userPangkatList as $index => $pangkat)
                            @if ($pangkat->task_status!='APPROVE')
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pangkat->pangkat->description }}/{{ $pangkat->pangkat->name }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $pangkat->file_sk_pangkat) }}" target="_blank"
                                            class="h6">
                                            <span class="badge bg-info">
                                                Lihat File <i class="mdi mdi-eye"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td>{{ $pangkat->tmt }}</td>
                                    <td>{{ $pangkat->created_at }}</td>
                                    <td class="text-center">
                                        <button data-bs-toggle="modal" data-bs-target="#exampleModalgrid{{ $pangkat->id }}"
                                            type="button" class="btn btn-success waves-effect btn-sm waves-light">
                                            <i class="ri-map-pin-line"></i>Terima
                                        </button>
                                    </td>
                                    <td class="text-center"><button type="button" data-bs-toggle="modal"
                                            data-bs-target="#tolak{{ $pangkat->id }}"
                                            class="btn btn-danger waves-effect btn-sm waves-light">
                                            <i class="ri-map-pin-line"></i>Tolak
                                        </button>
                                    </td>
                                </tr>
                                @endif
                                <div class="modal fade" id="exampleModalgrid{{ $pangkat->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success ">
                                                <h5 class="modal-title" id="exampleModalgridLabel">
                                                    Anda Menerima Data Riwayat
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Silahkan masukan komen pada field dibawah!</p>
                                                <form method="POST" action="{{ route('/task/user_j/pangkat/create') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="col-lg-12">
                                                            <div>
                                                                <input type="text" hidden value="{{ $pangkat->id }}"
                                                                    name="id">
                                                                <input type="text" hidden value="APPROVE"
                                                                    name="task_status">
                                                                <label for="exampleFormControlTextarea5"
                                                                    class="form-label">Komen</label>
                                                                <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" name="comment"></textarea>
                                                            </div>
                                                            <input type="text" hidden value="id_riwayat">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn bg-o"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- form tolak --}}
                                <div class="modal fade" id="tolak{{ $pangkat->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger ">
                                                <h5 class="modal-title text-white" id="exampleModalgridLabel">
                                                    Anda Menolak Data Riwayat Ini
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Silahkan masukan komen pada field dibawah!</p>
                                                <form method="POST"
                                                    action="{{ route('/task/user_j/pangkat/create') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="col-lg-12">
                                                            <div>
                                                                <input type="text" hidden value="{{ $pangkat->id }}"
                                                                    name="id">
                                                                <input type="text" hidden value="REJECT"
                                                                    name="task_status">
                                                                <label for="exampleFormControlTextarea5"
                                                                    class="form-label">Komen</label>
                                                                <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" name="comment"></textarea>
                                                            </div>
                                                            <input type="text" hidden value="id_riwayat">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn bg-o"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
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
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
    </div>
@endsection
