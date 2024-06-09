@extends('layout.v_wrapper')
@section('title')
    Verifikasi Formasi
@endsection
@section('content')
    @livewire('formasi.formasi-task', ['formasi_id' => $id])
@endsection
