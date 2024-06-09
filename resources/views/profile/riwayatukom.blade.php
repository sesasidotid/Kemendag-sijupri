<div class="card-body" id="tablex">
    <table class="main-table  table table-bordered nowrap align-middle" style="width:100%">
        <thead class="bg-light  ">
            <tr>
                <th>No</th>
                <th>Periode UKom</th>
                <th>Jenis Kompentensi</th>
                <th>Status Verifikasi</th>

                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($ukomList))
                @foreach ($ukomList as $index => $ukom)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <th>{{ date('F Y', strtotime($ukom->periode)) }}</th>
                        <th>{{ $ukom->jenis }}</th>
                        <td>{{ $ukom->task_status }}</td>

                        <td><a href="" class="btn btn-sm btn-secondary">Detail <i class="mdi mdi-eye"></i></a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
