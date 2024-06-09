<table class="main-table table nowrap align-middle" style="width:100%">

    <thead>
        <tr>
            <th>No</th>
            <th>Pangkat</th>
            <th>SK Pangkat</th>
            <th>TMT</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userPangkatList as $index => $pangkat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pangkat->pangkat->description }}/{{ $pangkat->pangkat->name }}</td>
                <td>
                    <a class="link-info" href="javascript:void(0);"
                        onclick="previewModal({{ json_encode($pangkat->file_sk_pangkat ?? '-') }}, 'SK Pangkat')">
                        Lihat <i class=" las la-eye"></i>
                    </a>
                </td>
                <td>{{ $pangkat->tmt }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
