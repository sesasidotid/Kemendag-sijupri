@extends('layout.v_wrapper_h')
@section('content')
    <div class="row">
        @livewire('akp.akp-atasan', ['nip' => $nip])
    </div>
    <!--end row-->
@endsection
