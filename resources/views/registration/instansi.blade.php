@extends('layout.v_wrapper')
@section('title')
    Form Admin Instansi
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            @livewire('registration.admin-instansi')
        </div><!--end col-->
    </div>
@endsection
