<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Kategori Sertifikasi</th>
            <th scope="col">NO. SK</th>
            <th scope="col">Tanggal SK</th>
            <th scope="col">Wilayah Kerja</th>
            <th scope="col"> Tanggal Berlaku Mulai</th>
            <th scope="col"> Tanggal Berlaku Selesai</th>
            <th scope="col"> UU Yang Di Kawal</th>
            <th scope="col">Kartu Tanda Pengenal PPNS</th>
            <th scope="col">File SK</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1 ; ?>
        @foreach ($sertifikasi as $item)
        <tr>
            <td scope="col">{{$no++}}</td>
            <td scope="col">{{$item->kategori??'-'}}</td>
            <td scope="col">{{$item->nomor_sk??'-'}}</td>
            <td scope="col">{{$item->tanggal_sk??'-'}}</td>
            <th scope="col">{{$item->wilayah_kerja??'-'}}</th>
            <td scope="col">{{ \Carbon\Carbon::parse($item->berlaku_mulai??
                '')->format('d M Y')}}</td>
            <td scope="col">{{ \Carbon\Carbon::parse($item->berlaku_sampai??
                '')->format('d M Y')}}</td>
            <th scope="col"> {{$item->file_uu_kawalan ??''}}</th>
            <td scope="col">
                @if($item->file_ktp_ppns != null)

                <a href="{{Storage::url($item->file_ktp_ppns)??'-'}}" target="_blank">Lihat File <i
                        class="mdi mdi-eye"></i></a>
                @else
                -
                @endif
            </td>
            <td scope="col"><a href="{{Storage::url($item->file_doc_sk ??'-')}}" target="_blank">Lihat File <i
                        class="mdi mdi-eye"></i></a></td>


        </tr>
        @endforeach


    </tbody>
</table>