<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">TMT</th>
            <th scope="col">Pangkat</th>
            <th scope="col">File SK Jabatan</th>


        </tr>
    </thead>
    <tbody>
        @foreach ($pangkat as $item)
        <tr>
            <td scope="col">No</td>
            <td scope="col">{{ \Carbon\Carbon::parse($item->tmt??
                '')->format('M Y')}}</td>

            <td scope="col">{{$item->pangkat->name}}/{{$item->pangkat->description}}</td>

            <td scope="col"><a href="{{Storage::url($item->file_sk_pangkat)}}" target="_blank">Lihat File <i
                        class="mdi mdi-eye"></i></a>
            </td>

        </tr>
        @endforeach


    </tbody>
</table>