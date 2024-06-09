<div class="col-md-12">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center mb-0">Data Riwayat Kompetensi</h4>
            </div>
            <div class="card-body" id="tablex">
                <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
                    <thead class="bg-light  ">
                        <tr>
                            <th>No</th>
                            <th>Nama Kompetensi</th>
                            <th>Kategori Pengembangan</th>
                            <th>File Sertifikat</th>
                            <th>Status Verifikasi</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($kompetensiList))
                            @foreach ($kompetensiList as $index => $kompetensi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kompetensi->name }}</td>
                                    <td>{{ $kompetensi->kategori }}</td>
                                    <td><a href="{{Storage::url( $kompetensi->file_sertifikat)}}"
                                        target="_blank">Lihat File <i class="mdi mdi-eye"></i></a></td>
                                    <td>{{ $kompetensi->task_status }}</td>
                                    <td>{{ $kompetensi->comment ?? '' }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
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
