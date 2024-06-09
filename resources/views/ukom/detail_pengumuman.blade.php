@extends('layout.v_wrapper')
@section('title')
    PENGUMUMAN PENDAFTARAN UKOM
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="bg-primary-subtle position-relative">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h3>{{ $data->judul }}</h3>
                            <p class="mb-0 text-muted">{{ $data->created_at }}</p>
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
                <div class="card-body p-4">

                    <div class="d-flex">
                        <p>
                            <?php echo $data->isi; ?>
                        </p>
                    </div>





                </div>
            </div>
        </div>
    </div>
@endsection
