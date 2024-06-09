<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Kompentensi</th>
            <th scope="col">Kategori Pengembangan</th>
            <th scope="col">Tanggal Mulai</th>
            <th scope="col">Tanggal Selesai</th>
            <th scope="col">Tanggal Sertifikat</th>
            <th scope="col">File Sertifikat</th>


        </tr>
    </thead>
    <tbody>
        @foreach ($kompetensi as $item)
        <tr>
            <th scope="col">No</th>
            <th scope="col">{{$item->name}}</th>
            <th scope="col">{{$item->kategori}}</th>
            <th scope="col">{{ \Carbon\Carbon::parse($item->tgl_mulai??
                '')->format('M Y')}}</th>
            <th scope="col">{{ \Carbon\Carbon::parse($item->tgl_selesai??
                '')->format('M Y')}}</th>
            <th scope="col">{{ \Carbon\Carbon::parse($item->tgl_sertifikat??
                '')->format('M Y')}}</th>

            <td scope="col"><a href="{{Storage::url($item->file_sertifikat)}}" target="_blank">Lihat File <i
                        class="mdi mdi-eye"></i></a>
            </td>

        </tr>
        @endforeach


    </tbody>
</table>