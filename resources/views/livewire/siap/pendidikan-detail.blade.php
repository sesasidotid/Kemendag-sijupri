<div class="col-md-12">
    <!-- Striped Rows -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center mb-0">Data Riwayat Pendidikan</h4>
            </div>
            <div class="card-body" id="tablex">
                <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
                    <thead class="bg-light  ">
                        <tr>
                            <th>No</th>
                            <th>Pendidikan</th>
                            <th>Instansi</th>
                            <th>Jurusan</th>
                            <th>File Ijazah</th>
                            <th>Tanggal Ijazah</th>
                            <th>Status Verifikasi</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($pendidikanList))
                        @foreach ($pendidikanList as $index => $pendidikan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pendidikan->level }}</td>
                            <td>{{ $pendidikan->instansi_pendidikan }}</td>
                            <td>{{ $pendidikan->jurusan }}</td>
                            <td class="text-center">
                                <a class="link-info" href="javascript:void(0);"
                                    onclick="previewModal({{ json_encode($pendidikan->file_ijazah) }}, 'SK Jabatan')">

                                    <span class="badge bg-secondary-subtle text-secondary">Lihat <i
                                            class="mdi mdi-eye"></i></span>
                                </a>
                            </td>
                            <td>{{$pendidikan->tgl_ijasah}} 1</td>
                            <td><span class="badge bg-secondary-subtle text-secondary">Re-open</span></td>
                            <td>{{$pendidikan->tgl_ijasah}}</td>
                            <td class="text-center">
                                <a class="link-info" href="javascript:void(0);"
                                    onclick="previewModal({{ json_encode($pendidikan->file_ijazah) }}, 'SK Jabatan')">

                                    <span class="badge bg-danger-subtle text-secondary">Lihat <i
                                            class="mdi mdi-eye"></i></span>
                                </a>
                                <a class="link-danger" href="javascript:void(0);"
                                    onclick="previewModal({{ json_encode($pendidikan->file_ijazah) }}, 'SK Jabatan')">

                                    <span class="badge bg-danger-subtle text-danger">Hapus <i
                                            class=" las la-trash"></i></span>
                                </a>
                            </td>
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
