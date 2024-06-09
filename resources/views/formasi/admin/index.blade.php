@extends('layout.v_wrapper')
@section('title')
    Formasi
@endsection
@section('content')
    <div class="row">
        <div class="card" id="applicationList">
            <div class="col-xxl-6">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#OPD" role="tab">
                                Unit Kerja/Instansi Daerah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#PendingFormasi" role="tab">
                                Pending Formasi
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="OPD" role="tabpanel">
                            @include('formasi.admin.opd')
                        </div>
                        <div class="tab-pane" id="PendingFormasi" role="tabpanel">
                            @include('formasi.admin.task')
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!--end col-->
        </div><!--end row-->
    </div>
    <!--end row-->
@endsection
