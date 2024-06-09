@extends('layout.v_wrapper')
@section('title')
    Detail Konfigurasi Sistem
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <form method="POST" action="{{ route('/maintenance/konfigurasi/edit', ['code' => $systemConfiguration->code]) }}">
        @csrf
        @method('PUT')
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <div class="flex-shrink-0 alert alert-primary w-100">
                        Detail Konfigurasi Sistem ({{ $systemConfiguration->name }})
                        <button type="submit" class="btn btn-md btn-primary float-end">
                            Ubah <i class=" las la-save"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if (isset($systemConfiguration->type) && $systemConfiguration->type === 'dynamic')
                            @include('maintenance.system_configuration.helper_dynamic', [
                                'property' => $systemConfiguration->property,
                                'count' => 0,
                            ])
                        @else
                            @include('maintenance.system_configuration.helper', [
                                'property' => $systemConfiguration->property,
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
