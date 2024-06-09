@php
    $user = auth()->user();
@endphp
<div class="row">
    <div class="col-lg-12">
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
                                        <div class="hstack gap-3 flex-wrap">
                                            <div><i class=" bx bx-id-card mr-1"></i> <span class="fw-medium">NIP :
                                                    {{ $user->nip }}</span></div>
                                            <div class="vr"></div>
                                            <div><i class="mdi mdi-details"></i>
                                                <span class="fw-medium">Tempat Kerja</span>
                                            </div>
                                            <div class="vr"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs-custom border-bottom-0 gap-2" role="tablist">
                        {{-- <li class="nav-item" role="presentation">
                            <a href="{{ route('/profile/detail') }}"
                                class=" fw-semibold btn btn-primary waves-effect btn-sm " style="font-size: 0.8rem"
                                aria-selected="true">
                                <i class="mdi mdi-account"></i> Detail Profil
                            </a>
                        </li> --}}
                        <li class="nav-item font-20" role="presentation">
                            <a class=" fw-semibold btn btn-primary waves-effect btn-sm " style="font-size: 0.8rem"
                                href="{{ route('/profile') }}" aria-selected="false" tabindex="-1">
                                <i class="mdi mdi-account-edit"></i> Perbaharui Riwayat </a>
                        </li>
                    </ul>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
