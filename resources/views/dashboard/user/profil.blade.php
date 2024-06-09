@php
    $user = auth()->user();
    $userDetail = $user->userDetail;
    $userJabatan = $user->jabatan ?? null;
    $userPangkat = $user->pangkat ?? null;
@endphp
<div class="row">
    <div class="col-lg-12">
        @if (!isset($userDetail) || $userDetail == null)
            <div class="alert alert-danger" role="alert">
                <strong> Anda Belum Melengkapi Profil! </strong>
            </div>
        @elseif($user->user_status !== "ACTIVE")
            <div class="alert alert-warning" role="alert">
                <strong>Akun Anda Tidak Aktif</strong>
            </div>
        @endif
        <div class="card mt-n4">
            <div class="bg-primary-subtle p-2">
                <div class="card-body pb-0 px-4">
                    <div class="row mb-3">
                        <div class="col-md">
                            <div class="row align-items-center g-3">
                                <div class="col-md-auto">
                                    <div class="avatar-md">
                                        <div class="avatar-title bg-white rounded-circle">
                                            <img src="{{ asset('build/images/brands/slack.png') }}" alt=""
                                                class="avatar-xs">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div>
                                        <h4 class="fw-bold">{{ $user->name }}</h4>
                                        <table>
                                            <tr class="bg-white border-primary border-bottom">
                                                <td class="fw-medium p-1">
                                                    <i class="bx bx-id-card me-1"></i>NIP
                                                </td>
                                                <td class="p-1">
                                                    <span>: {{ $user->nip }}</span>
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-primary border-bottom">
                                                <td class="fw-medium p-1">
                                                    <i class="mdi mdi-details me-1"></i>Unit Kerja/Instansi Daerah
                                                </td>
                                                <td class="p-1">
                                                    <span>: {{ $user->unitKerja->name }}</span>
                                                </td>
                                            </tr>
                                            @if ($userJabatan)
                                                <tr class="bg-white border-primary border-bottom">
                                                    <td class="fw-medium p-1">
                                                        <i class="mdi mdi-details me-1"></i>Jabatan
                                                    </td>
                                                    <td class="p-1">
                                                        <span>:
                                                            {{ $userJabatan->jabatan->name }}</span>
                                                    </td>
                                                </tr>
                                                <tr class="bg-white border-primary border-bottom">
                                                    <td class="fw-medium p-1">
                                                        <i class="mdi mdi-details me-1"></i>Jenjang
                                                    </td>
                                                    <td class="p-1">
                                                        <span>:
                                                            {{ $userJabatan->jenjang->name }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($userPangkat)
                                                <tr class="bg-white border-primary border-bottom">
                                                    <td class="fw-medium p-1">
                                                        <i class="mdi mdi-details me-1"></i>Pangkat
                                                    </td>
                                                    <td class="p-1">
                                                        <span>:
                                                            {{ $userPangkat->pangkat->name }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs-custom border-bottom-0 gap-2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('/profile/detail') }}"
                                class=" fw-semibold btn btn-primary waves-effect btn-sm " style="font-size: 0.8rem"
                                aria-selected="true">
                                <i class="mdi mdi-account"></i> Detail Profil
                            </a>
                        </li>
                        <li class="nav-item font-20" role="presentation">
                            <a class=" fw-semibold btn btn-primary waves-effect btn-sm " style="font-size: 0.8rem"
                                href="{{ route('/profile') }}" aria-selected="false" tabindex="-1">
                                <i class="mdi mdi-account-edit"></i> Perbaharui Riwayat </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
