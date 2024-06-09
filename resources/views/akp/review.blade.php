@extends('layout.v_wrapper')
@section('title')
    AKP Review
@endsection
@section('content')
    <div class="row">
        @if (isset($akpList) && count($akpList) > 0)
            <div class="flex-shrink-0 alert alert-primary">
                <strong> Hi! </strong>Di bawah ini merupakan daftar <b>AKP</b>
            </div>
            @foreach ($akpList as $akp)
                <div class="row">
                    <div class="col card card-animate card-body">
                        <h4>Instrumen {{ $akp->akpInstrumen->name }}</h4>
                        <h6>
                            Periode : {{ date($akp->tanggal_mulai) }} - {{ date($akp->tanggal_selesai) }}
                        </h6>
                        <div class="col">
                            @if ($akp->akp_status == 'ATASAN_REKAN_REVIEWED')
                                <a href="{{ route('/akp/review/personal', ['id' => $akp->id]) }}"
                                    class="btn btn-success">review</a>
                            @else
                                <a href="{{ route('/akp/review/rekomendasi', ['id' => $akp->id]) }}"
                                    class="btn btn-info">Rekomendasi Pelatihan</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="flex-shrink-0 alert alert-primary">
                <strong> Hi! </strong>Belum ada daftar <b>AKP</b> Yang dapat di review
            </div>
            <div class="row">
                <div class="col card card-body">
                </div>
            </div>
        @endif
    </div>
    <!--end row-->
@endsection
