<div>
    <div class="card-header bg-light mt-4">
        <h4 class="text-center">Data Riwayat Pangkat</h4>
    </div>
    <table class="main-table table table-bordered nowrap align-middle w-100">
        <thead>
            <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">pangkat</th>
                <th scope="col">SK Pangkat</th>
                <th scope="col">Comment </th>
                <th scope="col">Action</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($userPangkatList))
                @foreach ($userPangkatList as $index => $pangkat)
                    <tr>
                        <td scope="col">{{ $index + 1 }}</td>
                        <td scope="col">{{ $pangkat->pangkat->name }}</td>
                        <td class="text-center" scope="col">
                            <a class="link-info" href="javascript:void(0);"
                                onclick="previewModal({{ json_encode($pangkat->file_sk_pangkat) }}, 'SK Pangkat')">

                                <span class="badge bg-secondary-subtle text-secondary">Lihat <i
                                    class="mdi mdi-eye"></i></span>
                            </a>
                        </td>
                        <td  scope="col" class="p-1 text-center">
                            --
                        </td>
                        <td  scope="col" class="p-1 text-center">
                            <a class="link-danger ps-1 border-start">

                                <span class="badge bg-danger-subtle text-danger font-20">Lihat <i
                                    class="mdi mdi-delete-circle-outline font-20"></i></span>
                            </a>
                        </td>
                        <td scope="col" class="p-1 text-center">{{ $pankat->task_status ?? 'menunggu verifikasi' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
