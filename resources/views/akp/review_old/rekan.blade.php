@extends('layout.v_wrapper_h')
@section('content')
    <div class="row">
        @livewire('akp.akp-rekan', ['nip' => $nip])
    </div>
    <!--end row-->
@endsection
