<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Periode</th>
            <th scope="col">Tanggal Mulai</th>
            <th scope="col">Tanggal Selesai</th>
            <th scope="col">Nilai Kinerja</th>
            <th scope="col">Nilai Perilaku</th>
            <th scope="col">Predikat</th>
            <th scope="col">Angka Kredit</th>
            <th scope="col">File Angka Kredit</th>
            <th scope="col">File Evaluasi</th>
            <th scope="col">File Akumulasi</th>



        </tr>
    </thead>
    <tbody>
        <?php $no=1 ; ?>
        @foreach ($pak as $item)
        <tr>
            <td scope="col">{{$no++}}</td>
            <td scope="col">{{$item->periode}}</td>
            <td scope="col">{{ \Carbon\Carbon::parse($item->tgl_mulai??
                '')->format('d M Y')}}</td>
            <td scope="col">{{ \Carbon\Carbon::parse($item->tgl_selesai??
                '')->format('d M Y')}}</td>
            <td scope="col">{{$item->nilai_kinerja}}</td>
            <td scope="col">{{$item->nilai_perilaku}}</td>
            <td scope="col">{{$item->predikat}}</td>
            <td scope="col">{{$item->angka_kredit}}</td>
            <td scope="col"><a href="{{Storage::url($item->file_doc_ak)}}" target="_blank">Lihat File <i
                class="mdi mdi-eye"></i></a></td>
            <td scope="col"><a href="{{Storage::url($item->file_hasil_eva)}}" target="_blank">Lihat File <i
                class="mdi mdi-eye"></i></a></td>
            <td scope="col"><a href="{{Storage::url($item->file_akumulasi_ak)}}" target="_blank">Lihat File <i
                class="mdi mdi-eye"></i></a></td>


        </tr>
        @endforeach


    </tbody>
</table>