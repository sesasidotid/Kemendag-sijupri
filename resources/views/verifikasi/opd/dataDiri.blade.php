@extends('layout.v_wrapper')
@section('title')
    Detail Riwayat Jabatan
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
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="bg-primary-subtle position-relative">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h3>{{ $user->name }}</h3>
                            <p class="mb-0 text-muted">{{ $user->created_at }} </p>
                        </div>
                    </div>
                    <div class="shape">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns:svgjs="http://svgjs.com/svgjs" width="1440" height="60" preserveAspectRatio="none"
                            viewBox="0 0 1440 60">
                            <g mask="url(&quot;#SvgjsMask1001&quot;)" fill="none">
                                <path d="M 0,4 C 144,13 432,48 720,49 C 1008,50 1296,17 1440,9L1440 60L0 60z"
                                    style="fill: var(--vz-secondary-bg);"></path>
                            </g>
                            <defs>
                                <mask id="SvgjsMask1001">
                                    <rect width="1440" height="60" fill="#ffffff"></rect>
                                </mask>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="row">
                    <div class=" p-4 col-md-6">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">Nama</label>
                                    <input type="text" readonly class="form-control" id="employeeName"
                                        placeholder="Enter emploree name" value="{{ $user->name }}">
                                </div>

                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">NIK</label>
                                    <input type="text" readonly class="form-control" id="employeeName"
                                        placeholder="Enter emploree name" value="{{ $userDetail->nik }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">NIP</label>
                                    <input type="text" readonly class="form-control" id="employeeName"
                                        placeholder="Enter emploree name" value="{{ $user->nip }}">
                                </div>

                            </div>

                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">Jenis Kelamin</label>
                                    <input type="text" readonly class="form-control" id="employeeName"
                                        placeholder="Enter emploree name" value="{{ $userDetail->name }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">Alamat Email</label>
                                    <input type="text" readonly class="form-control" id="employeeName"
                                        placeholder="Enter emploree name" value="{{ $userDetail->email }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">No HP</label>
                                    <input type="text" readonly class="form-control" id="employeeName"
                                        placeholder="Enter emploree name" value="{{ $userDetail->no_hp }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">Tempat Lahir</label>
                                    <input type="text" readonly class="form-control" id="employeeName"
                                        placeholder="Enter emploree name" value="{{ $userDetail->tempat_lahir }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">Tanggal Lahir</label>
                                    <input type="text" readonly class="form-control" id="employeeName"
                                        placeholder="Enter emploree name" value="{{ $userDetail->tanggal_lahir }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <label for="employeeName" class="form-label text-muted">File KTP</label>
                                    <a class="btn btn-primary btn-sm" href="{{ asset('storage/' . $userDetail->file_ktp) }}">
                                        Lihat File <i class="mdi mdi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if ($userDetail->task_status != 'APPROVE')
                            <form action="{{ route('/task/user_jf/detail/create') }}" method="POST">
                                @csrf
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i data-feather="check-circle" class="text-success icon-dual-success icon-xs"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="text" hidden value="{{ $userDetail->id }}" name="id">
                                        <div class="mb-3">
                                            <label for="employeeName" class="form-label">Status Verifikasi</label>
                                            <select class="form-control" name="task_status">
                                                <option disabled selected>Pilih status Verifikasi</option>
                                                <option value="APPROVE">Terima</option>
                                                <option value="REJECT">Tolak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                </div>
                            </form>
                        @endif
                        <div class="d-flex">
                            <div class="">
                                <a style="font-size: 0.9rem" href="/admin/verifikasi/riwayat-pendidikan"
                                    class=" h7 btn-primary btn-sm">Pendidikan<i class="las la-angle-double-right"></i></a>
                                <a style="font-size: 0.9rem" href="/admin/verifikasi/riwayat-jabatan"
                                    class="h7  btn-primary btn-sm">Jabatan <i class="las la-angle-double-right"></i></a>
                                <a style="font-size: 0.9rem"href="/admin/verifikasi/riwayat-pangkat"
                                    class=" h7 btn-primary btn-sm">Pangkat <i class="las la-angle-double-right"></i></a>
                                <a style="font-size: 0.9rem" href="/admin/verifikasi/riwayat-kinerja"
                                    class="h7  btn-primary btn-sm">Kinerja <i class="las la-angle-double-right"></i></a>
                                <a style="font-size: 0.9rem" href="/admin/verifikasi/riwayat-kompetensi"
                                    class="h7  btn-primary btn-sm">Kompentensi<i class="las la-angle-double-right"></i></a>
                                <a style="font-size: 0.9rem"href="/admin/verifikasi/riwayat-sertifikasi"
                                    class=" h7 btn-primary btn-sm">sertifikasi <i class="las la-angle-double-right"></i></a>
                                <a style="font-size: 0.9rem" href="/admin/verifikasi/riwayat-ukom"
                                    class="h7  btn-primary btn-sm">ukom <i class="las la-angle-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <div class="card-header">
                                <h4>File KTP</h4>
                            </div>
                            <iframe id="serviceFrameSend" src="{{ asset('storage/' . $userDetail->file_ktp) }}" height="1000" width="100%"  frameborder="0">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
