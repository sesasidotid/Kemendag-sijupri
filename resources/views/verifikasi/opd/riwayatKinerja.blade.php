@extends('layout.v_wrapper')
@section('title')
    Detail Riwayat Kinerja
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
                    <h4 class="card-title mb-0 flex-grow-1">Data Riwayat Kinerja</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <table class="main-table table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahuanan/Bulanan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Nilai Kinerja</th>
                                <th>Nilai Prilaku</th>
                                <th>Predikat</th>
                                <th>Angka Kredit</th>
                                <th>File Angka Kredit</th>
                                <th>File Hasil Evaluasi</th>
                                <th>File Akumulasi Angka Kredit</th>
                                <th>File Konversi Kerja</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Action Terima</th>
                                <th>Action Tolak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userPakList as $index => $kinerja)
                                @if ($kinerja->task_status!='APPROVE')
                                    <tr>
                                        <th>{{ $index }}</th>
                                        <th>{{ $kinerja->periode }}</th>
                                        <th>{{ $kinerja->tgl_mulai }}</th>
                                        <th>{{ $kinerja->tgl_selesai }}</th>
                                        <th>{{ $kinerja->nilai_kinerja }}</th>
                                        <th>{{ $kinerja->perilaku }}</th>
                                        <th>{{ $kinerja->predikat }}</th>
                                        <th>{{ $kinerja->angka_kredit }}</th>
                                        <td>
                                            <a href="{{ asset('storage/' . $kinerja->file_doc_ak ?? '') }}" target="_blank"
                                                class="h6">
                                                <span class="badge bg-info">
                                                    Lihat File <i class="mdi mdi-eye"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $kinerja->file_hasil_eval) }}" target="_blank"
                                                class="h6">
                                                <span class="badge bg-info">
                                                    Lihat File <i class="mdi mdi-eye"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $kinerja->file_akumulasi_ak) }}" target="_blank"
                                                class="h6">
                                                <span class="badge bg-info">
                                                    Lihat File <i class="mdi mdi-eye"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $kinerja->file_konversi_kerja ?? '') }}"
                                                target="_blank" class="h6">
                                                <span class="badge bg-info">
                                                    Lihat File <i class="mdi mdi-eye"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <th>Tanggal Pengajuan</th>
                                        <td class="text-center">
                                            <button data-bs-toggle="modal"
                                                data-bs-target="#exampleModalgrid{{ $kinerja->id }}" type="button"
                                                class="btn btn-success waves-effect btn-sm waves-light">
                                                <i class="ri-map-pin-line"></i>Terima
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#tolak{{ $kinerja->id }}"
                                                class="btn btn-danger waves-effect btn-sm waves-light">
                                                <i class="ri-map-pin-line"></i>Tolak
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                                {{-- form terima --}}
                                <div class="modal fade" id="exampleModalgrid{{ $kinerja->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success ">
                                                <h5 class="modal-title" id="exampleModalgridLabel">
                                                    Anda Menerima Data Riwayat
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Silahkan masukan komen pada field dibawah!</p>
                                                <form method="POST"
                                                    action="{{ route('/task/user_j/kinerja/create') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div>
                                                                <input type="text" hidden value="{{ $kinerja->id }}"
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
                                <div class="modal fade" id="tolak{{ $kinerja->id }}" tabindex="-1"
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
                                                    action="{{ route('/task/user_j/kinerja/create') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div>
                                                                <input type="text" hidden value="{{ $kinerja->id }}"
                                                                    name="id">
                                                                <input type="text" hidden value="REJECT"
                                                                    name="task_status">
                                                                <label for="exampleFormControlTextarea5"
                                                                    class="form-label">Komen
                                                                </label>
                                                                <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" name="comment"></textarea>
                                                            </div>
                                                            <input type="text" hidden value="id_riwayat">
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn bg-o"
                                                                    data-bs-dismiss="modal">Close
                                                                </button>
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
