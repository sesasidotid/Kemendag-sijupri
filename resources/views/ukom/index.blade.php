@extends('layout.v_wrapper')
@section('title')
UKOM KENAIKAN JENJANG
@endsection
@section('content')
<div class="row">
    @if ($periode==null)
    <div class="alert border-0 alert-danger" role="alert">
        <strong> MAAF! </strong> Periode UKOM Belum Di Buka.
    </div>
    @else



    @if (isset($periode) && $userUkom==true)
    <!-- Primary Alert -->
    <div class="alert alert-success" role="alert">
      <strong> Hi! </strong> UKOM TELAH DI BUKA, SILAHKAN LAKUKAN <B>PENDAFTARAN!</B>
  </div>

  <div class="col-md-6 bg-light" >
      <div class="card overflow-hidden">
          <div class="card-body bg-marketplace d-flex">
              <div class="flex-grow-1">
                  <h4 class="fs-18 lh-base mb-0"> <br> <span
                          class="text-success">KENAIKAN JENJANG</span> </h4>
                  <p class="mb-0 mt-2 pt-1 text-muted">Silahkan cek formasi</p>
                  <div class="d-flex gap-3 mt-4">
                      <a href="/ukom/kenaikan-jenjang/baru" class="btn btn-primary btn-md fw-bold"> Baru</a>
                      <a href="/ukom/kenaikan-jenjang/mengulang" class="btn btn-danger btn-md fw-bold"> Mengulang</a>
                  </div>
              </div>

          </div>
      </div>
  </div>
  <div class="col-md-6 bg-light" >
      <div class="card overflow-hidden">
          <div class="card-body bg-marketplace d-flex">
              <div class="flex-grow-1">
                  <h4 class="fs-18 lh-base mb-0"> <br> <span
                          class="text-success">PROMOSI</span> </h4>
                  <p class="mb-0 mt-2 pt-1 text-muted">Silahkan cek formasi</p>
                  <div class="d-flex gap-3 mt-4">
                      <a href="/ukom/promosi/baru" class="btn btn-primary btn-md fw-bold"> Baru</a>
                      <a href="/ukom/promosi/mengulang" class="btn btn-danger btn-md fw-bold"> Mengulang</a>
                  </div>
              </div>

          </div>
      </div>
  </div>
  @elseif($userUkom==false)
  <div class="alert border-0 alert-warning" role="alert">
      <strong>KAMU TELAH MENDAFTAR UKOM, SILAHKAN MENUNGGU HASIL PENGUMUMAN</strong>
  </div>



  @endif
    @endif





</div>
@endsection