@extends('layout.v_wrapper')
@section('title')
    Data Pejabat Fungsional Instansi Daerah
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">

            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary">
                    <!-- Primary Alert -->
                    <strong> Hi! </strong>Di bawah ini merupakan daftar <b>Pejabat Fungsional</b> yang perlu di verifikasi.
                    Silahkan lakukan verifikasi tiap user.
                </div>
            </div><!-- end card header -->
            <div class="card-body">
                <table id="main-table" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Nip</th>
                            <th class="text-center"> Data Diri</th>
                            <th class="text-center"> Riwayat Pendidikan</th>
                            <th class="text-center">Riwayat Jabatan</th>
                            <th class="text-center">Riwayat Pangkat</th>
                            <th class="text-center">Riwayat Kompetensi</th>
                            <th class="text-center">Riwayat Sertifikasi</th>
                            <th class="text-center">Status User</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($userList))
                            @foreach ($userList as $index => $user)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->nip }}</td>
                                        <td>
                                            @if (isset($user->userDetail))
                                                @if ($user->userDetail->task_status == null || $user->userDetail->task_status == 'PENDING')
                                                    <a class="btn btn-soft-warning btn-sm "
                                                        href="{{ route('/task/user_jf/detail', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Perlu Diverifikasi
                                                    </a>
                                                @else
                                                    <a class="btn btn-soft-primary btn-sm "
                                                        href="{{ route('/task/user_jf/detail', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Lihat
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-gray">Belum Diajukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->checkPendidikan() !== null)
                                                @if (!$user->checkPendidikan())
                                                    <a class="btn btn-soft-warning btn-sm "
                                                        href="{{ route('/task/user_jf/pendidikan', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Perlu Diverifikasi
                                                    </a>
                                                @else
                                                    <a class="btn btn-soft-primary btn-sm "
                                                        href="{{ route('/task/user_jf/pendidikan', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Lihat
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-gray">Belum Diajukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->checkJabatan() !== null)
                                                @if (!$user->checkJabatan())
                                                    <a class="btn btn-soft-warning btn-sm "
                                                        href="{{ route('/task/user_jf/jabatan', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Perlu Diverifikasi
                                                    </a>
                                                @else
                                                    <a class="btn btn-soft-primary btn-sm "
                                                        href="{{ route('/task/user_jf/jabatan', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Lihat
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-gray">Belum Diajukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->checkPangkat() !== null)
                                                @if (!$user->checkPangkat())
                                                    <a class="btn btn-soft-warning btn-sm "
                                                        href="{{ route('/task/user_jf/pangkat', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Perlu Diverifikasi
                                                    </a>
                                                @else
                                                    <a class="btn btn-soft-primary btn-sm "
                                                        href="{{ route('/task/user_jf/pangkat', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Lihat
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-gray">Belum Diajukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->checkKompetensi() !== null)
                                                @if (!$user->checkKompetensi())
                                                    <a class="btn btn-soft-warning btn-sm "
                                                        href="{{ route('/task/user_jf/kompetensi', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Perlu Diverifikasi
                                                    </a>
                                                @else
                                                    <a class="btn btn-soft-primary btn-sm "
                                                        href="{{ route('/task/user_jf/kompetensi', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Lihat
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-gray">Belum Diajukan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->checkSertifikasi() !== null)
                                                @if (!$user->checkSertifikasi())
                                                    <a class="btn btn-soft-warning btn-sm "
                                                        href="{{ route('/task/user_jf/sertifikasi', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Perlu Diverifikasi
                                                    </a>
                                                @else
                                                    <a class="btn btn-soft-primary btn-sm "
                                                        href="{{ route('/task/user_jf/sertifikasi', ['nip' => $user->nip]) }}">
                                                        <i class="mdi mdi-eye"></i> Lihat
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-gray">Belum Diajukan</span>
                                            @endif
                                        </td>
                                        <td>

                                            @if ($user->user_status == "3")
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Belum Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="user/aktivasi/{{$user->nip}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                @if ($user->user_status == "3")
                                                    <button class="btn btn-soft-primary btn-sm" name="aktivasi" value="NOT_ACTIVE"
                                                        type="submit">
                                                        Non Aktifkan
                                                    </button>
                                                @else
                                                    <button class="btn btn-soft-primary btn-sm" name="aktivasi" value="ACTIVE"
                                                        type="submit">
                                                        Aktifkan
                                                    </button>

                                                @endif
                                            </form>
                                        </td>
                                    </tr>

                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
