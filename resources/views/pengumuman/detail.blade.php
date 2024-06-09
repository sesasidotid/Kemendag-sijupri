@extends('layout.v_wrapper')
@section('title')
    Pengumuman
@endsection
@section('ext_header')
    @include('layout.css_tables')\
    <style>
        .announcement-content {
            max-width: 100%;
            overflow: hidden;
        }

        .announcement-content img {
            max-width: 100%;
            height: auto;
        }
    </style>
@endsection
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12 d-flex justify-content-center">
        <div class="card" style="width: 80%;">
            <div class="card-header align-items-center d-flex">
                <h3>{{ $announcement->title }}</h3>
            </div>
            <div class="card-body">
                <div class="announcement-content">
                    {!! $announcement->content !!}
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
@endsection
