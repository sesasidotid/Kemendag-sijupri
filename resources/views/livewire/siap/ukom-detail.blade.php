<div class="col-md-12">
    <div class="col-lg-12">
        <div class="d-flex justify-content-end bg-light ">
            <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                <li class="list-inline-item">
                    <span class="badge bg-primary-subtle text-primary">
                        <a class="align-middle minimize-card text-primary" data-bs-toggle="collapse" href="#tablex"
                            role="button" aria-expanded="false" aria-controls="collapseExample2">
                            <i class="mdi mdi-plus align-middle plus"><span
                                    style="font-style: normal ; font-size: 14px">Maximize Form</span></i>
                            <i class="mdi mdi-minus align-middle minus"><span
                                    style="font-style: normal ; font-size: 14px">Minimize Form</span></i>
                        </a>
                    </span>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center mb-0">Data Riwayat UKom</h4>
            </div>
            <div class="card-body" id="tablex">
                <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
                    <thead class="bg-light  ">
                        <tr>
                            <th>No</th>
                            <th>Periode UKom</th>
                            <th>Jenis Kompentensi</th>
                            <th>Status Verifikasi</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($ukomList))
                            @foreach ($ukomList as $index => $ukom)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <th>{{ $ukom->periode }}</th>
                                    <th>{{ $ukom->jenis }}</th>
                                    <td>{{ $ukom->task_status }}</td>
                                    <td>Comment</td>
                                    <td>Action</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <a href="/dashboard/user" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
