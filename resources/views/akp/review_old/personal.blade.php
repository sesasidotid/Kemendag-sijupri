@extends('layout.v_wrapper_h')
@section('content')
    <div class="row">
        @livewire('akp.akp-personal', ['akp_id' => $id])
    </div>
    <!--end row-->
@endsection
