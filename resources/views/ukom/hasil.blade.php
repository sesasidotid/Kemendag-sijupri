@extends('layout.v_wrapper')
@section('title')
PENGUMUMAN HASIL PENDAFTARAN UKOM
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            @if($ukom->task_status === 'APPROVE' )
            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissible alert-additional fade show" role="alert">
                <div class="alert-body">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <i class="ri-notification-off-line fs-16 align-middle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading">Yey! Selamat Anda Telah Diterima Untuk Mengikuti UKOM!</h5>
                            <p class="mb-0">Silahkan Menunggu Pemberitahuan Jadwal </p>
                        </div>
                    </div>
                </div>
                <div class="alert-content">

                </div>
            </div>
            @else
            <div class="alert alert-danger alert-dismissible alert-additional fade show" role="alert">
                <div class="alert-body">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <i class="ri-notification-off-line fs-16 align-middle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading">Maaf! Berkas Anda Ditolak!</h5>

                            @if($ukom->tipe_ukom=='baru' && $ukom->jenis_ukom=='kenaikan_jenjang')
                            <p class="mb-0">Silahkan Ajukan Sanggahan <a href="/ukom/hasil/ukom/baru/sanggah/"
                                    class="btn btn-danger btn-sm">Sanggah <i class="mdi mdi-arrow-right"></i></a> </p>
                            @endif
                            @if($ukom->tipe_ukom=='mengulang' && $ukom->jenis_ukom=='kenaikan_jenjang')
                            <p class="mb-0">Silahkan Ajukan Sanggahan <a href="/ukom/hasil/ukom/baru/sanggah/"
                                    class="btn btn-danger btn-sm">Sanggah <i class="mdi mdi-arrow-right"></i></a> </p>
                            @endif
                            @if($ukom->tipe_ukom=='baru' && $ukom->jenis_ukom=='promosi')
                            <p class="mb-0">Silahkan Ajukan Sanggahan <a href="/ukom/hasil/ukom/baru/sanggah/promosi"
                                    class="btn btn-danger btn-sm">Sanggah <i class="mdi mdi-arrow-right"></i></a> </p>
                            @endif
                            @if($ukom->tipe_ukom=='mengulang' && $ukom->jenis_ukom=='promosi')
                            <p class="mb-0">Silahkan Ajukan Sanggahan <a href="/ukom/hasil/ukom/mengulang/sanggah/promosi"
                                    class="btn btn-danger btn-sm">Sanggah <i class="mdi mdi-arrow-right"></i></a> </p>
                            @endif
                            <div class="flex-grow-1">
                                Comment :
                                {{$ukom->comment}}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="alert-content">

                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection