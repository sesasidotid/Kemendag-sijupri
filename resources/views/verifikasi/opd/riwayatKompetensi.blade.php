@extends('layout.v_wrapper')
@section('title')
    Detail Riwayat Kompentensi
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
                    <h4 class="card-title mb-0 flex-grow-1">Data Riwayat Kompentensi</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <table class="main-table table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kompentesi</th>
                                <th>Kategori Pengembangan</th>
                                <th>Tanggal Kompetensi</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Action Terima</th>
                                <th>Action Tolak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userKompetensiList as $index => $kompetensi)
                                @if ($kompetensi->task_status!='APPROVE')
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th>{{ $kompetensi->name }}</th>
                                        <th>{{ $kompetensi->kategori }}</th>
                                        <th>{{ $kompetensi->tgl_sertifikat }}</th>
                                        <th>{{ $kompetensi->created_at }}</th>
                                        <td class="text-center">
                                            <button data-bs-toggle="modal"
                                                data-bs-target="#exampleModalgrid{{ $kompetensi->id }}" type="button"
                                                class="btn btn-success waves-effect btn-sm waves-light"><i
                                                    class="ri-map-pin-line">
                                                </i>Terima
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#tolak{{ $kompetensi->id }}"
                                                class="btn btn-danger waves-effect btn-sm waves-light"><i
                                                    class="ri-map-pin-line">
                                                </i>Tolak
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                                {{-- form terima --}}
                                <div class="modal fade" id="exampleModalgrid{{ $kompetensi->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success ">
                                                <h5 class="modal-title" id="exampleModalgridLabel">Anda Menerima Data
                                                    Riwayat
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Silahkan masukan komen pada field dibawah!</p>
                                                <form method="POST"
                                                    action="{{ route('/task/user_j/kompetensi/create') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div>
                                                                <input type="text" hidden value="{{ $kompetensi->id }}"
                                                                    name="id">
                                                                <input type="text" hidden value="APPROVE"
                                                                    name="task_status">
                                                                <label for="exampleFormControlTextarea5"
                                                                    class="form-label">Komen</label>
                                                                <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" name="comment"></textarea>
                                                            </div>
                                                            <input type="text" hidden value="id_riwayat">
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn bg-o"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row-->
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- form tolak --}}
                                <div class="modal fade" id="tolak{{ $kompetensi->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger ">
                                                <h5 class="modal-title text-white" id="exampleModalgridLabel">Anda Menolak
                                                    Data
                                                    Riwayat Ini </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Silahkan masukan komen pada field dibawah!</p>
                                                <form method="POST"
                                                    action="{{ route('/task/user_j/kompetensi/create') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div>
                                                                <input type="text" hidden value="{{ $kompetensi->id }}"
                                                                    name="id">
                                                                <input type="text" hidden value="REJECT"
                                                                    name="task_status">
                                                                <label for="exampleFormControlTextarea5"
                                                                    class="form-label">Komen</label>
                                                                <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" name="comment"></textarea>
                                                            </div>
                                                            <input type="text" hidden value="id_riwayat">
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn bg-o"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row-->
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
