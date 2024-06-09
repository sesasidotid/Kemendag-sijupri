<div class="col-md-12">
    <div class="col-lg-12  mt-1">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center mb-0">Data Riwayat Kompetensi</h4>
            </div>
            <div class="card-body" id="tablex">
                <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
                    <thead class="bg-light  ">
                        <tr>
                            <th>No</th>
                            <th>Kategori Sertifikasi</th>
                            <th>No SK</th>
                            <th>Tanggal SK</th>
                            <th>Wilayah Kerja</th>
                            <th>Tanggal Berlaku Mulai</th>
                            <th>Tanggal Berlaku Sampai</th>
                            <th>Dokument SK</th>
                            <th>UU Kawalan</th>
                            <th>Kartu Tanda Pengenal PPNS</th>
                            <th>Status Verifikasi</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($sertifikasiList))
                            @foreach ($sertifikasiList as $index => $sertifikasi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sertifikasi->kategori }}</td>
                                    <td>{{ $sertifikasi->nomor_sk }}</td>
                                    <td>{{ $sertifikasi->tanggal_sk }}</td>
                                    <td>{{ $sertifikasi->wilayah_kerja ?? '' }}</td>
                                    <td>{{ $sertifikasi->berlaku_mulai ?? '' }}</td>
                                    <td>{{ $sertifikasi->berlaku_sampai ?? '' }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-soft-primary btn-sm"
                                            href="{{ asset('storage/' . $sertifikasi->file_doc_sk) }}"
                                            target="_blank">
                                            Lihat <i class="mdi mdi-eye"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-soft-primary btn-sm"
                                            href="{{ asset('storage/' . $sertifikasi->file_uu_kawalan ?? '') }}"
                                            target="_blank">
                                            Lihat <i class="mdi mdi-eye"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-soft-primary btn-sm"
                                            href="{{ asset('storage/' . $sertifikasi->file_ktp_ppns ?? '') }}"
                                            target="_blank">
                                            Lihat <i class="mdi mdi-eye"></i>
                                        </a>
                                    </td>
                                    <td>Status Verifikasi</td>
                                    <td>Comment</td>
                                    <td>Action</td>
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
