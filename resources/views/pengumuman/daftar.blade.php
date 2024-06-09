@extends('layout.v_wrapper')
@section('title')
    AKP Review
@endsection
@section('content')
    <div class="row">
        @if (isset($announcementList) && count($announcementList) > 0)
            <div class="flex-shrink-0 alert alert-primary">
                <strong> Daftar Pengumuman </strong>
            </div>
            @foreach ($announcementList as $announcement)
                <a href="{{ route('/pengumuman/daftar/detail', ['id' => $announcement->id]) }}" class="mb-2">
                    <div class="card card-animate">
                        <div class="card-header">
                            <h4>{{ $announcement->title }}</h4>
                        </div>
                        <div class="card-body row" style="height: 200px; max-height: 200px; overflow: hidden;">
                            {!! $announcement->content !!}
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <div class="flex-shrink-0 alert alert-primary">
                <strong> Tidak Ada Pengumuman </strong>
            </div>
            <div class="row">
                <div class="col card card-body">
                </div>
            </div>
        @endif
    </div>
@endsection
