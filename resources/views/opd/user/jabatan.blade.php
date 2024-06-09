
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">TMT</th>
                <th scope="col">Nama Jabatan</th>
                <th scope="col">Jenjang</th>
                <th scope="col">File SK Jabatan</th>


            </tr>
        </thead>
        <tbody>
            <?php $no=1 ; ?>
            @foreach  ($jabatan as $item)
            <tr>
                <td scope="col">{{$no++}}</td>
                <td scope="col">{{ \Carbon\Carbon::parse($item->tmt??
                    '')->format('M Y')}}</td>

                <td scope="col">{{$item->name}}</td>
                <td scope="col">{{ Str::ucfirst($item->jenjang_code)}}</td>
                <td scope="col"><a href="{{Storage::url($item->file_sk_jabatan)}}"
                        target="_blank">Lihat File <i class="mdi mdi-eye"></i></a>
                </td>

            </tr>
            @endforeach


        </tbody>
    </table>
