@section('css_select')
    @include('layout.css_select')
@endsection
<div class="col-md-12">
    <div class="card-body">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center mb-0">Data Riwayat Jabatan</h4>
                </div>
                <div class="card-body" id="tablex">
                    <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
                        <thead class="bg-light  ">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">TMT</th>
                                <th scope="col">Tipe Jabatan</th>
                                <th scope="col">Jenjang</th>
                                <th scope="col">Nama Jabatan</th>
                                <th scope="col">SK Jabatan</th>
                                <th scope="col">Tanggal Pengajuan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($userJabatanList))
                                @foreach ($userJabatanList as $index => $jabatan)
                                    <tr>
                                        <td scope="col">{{ $index + 1 }}</td>
                                        <td scope="col">{{ $jabatan->tmt }}</td>
                                        <td scope="col">{{ $jabatan->tipe_jabatan }}</td>
                                        <td scope="col">{{ $jabatan->jenjang->name ?? '' }}</td>
                                        <td scope="col">{{ $jabatan->name }}</td>
                                        <td scope="col" class="text-center">
                                            <a class="link-danger" href="javascript:void(0);">

                                                <span class="badge bg-secondary-subtle text-secondary">Lihat <i
                                                        class=" las la-eye"></i></span>
                                            </a>
                                        </td>
                                        <td scope="col" class="p-1">
                                            {{ $jabatan->created_at }}
                                        </td>
                                        <td scope="col">{{ $jabatan->task_status ?? 'menunggu verifikasi' }}</td>
                                        <td scope="col">--</td>
                                        <td scope="col">
                                            <a class="link-danger" href="javascript:void(0);">
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
</div>
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
