<table class="table mb-0">
    <tbody>
        <tr>
            <th scope="row" style="width: 150px;">Nama</th>
            <td>{{ucwords($user->name)}}</td>
        </tr>
        <tr>
            <th scope="row">NIP</th>
            <td>{{$dataDiri->nip}}</td>
        </tr>
        <tr>
            <th scope="row">NIK</th>
            <td>{{$dataDiri->nik}}</td>
        </tr>
        <tr>
            <th scope="row">Jenis Kelamin</th>
            <td>{{$dataDiri->jenis_kelamin}}</td>
        </tr>
        <tr>
            <th scope="row">No HP</th>
            <td>{{$dataDiri->no_hp}}</td>
        </tr>
        <tr>
            <th scope="row">Tempat Lahir</th>
            <td>{{$dataDiri->tempat_lahir}}</td>
        </tr>
        <tr>
            <th scope="row">Tanggal Lahir</th>
            <td>{{ date('d-m-Y',strtotime($dataDiri->tanggal_lahir))}}</td>
        </tr>
        <tr>
            <th scope="row">File KTP</th>
            <td><a href="{{Storage::url($dataDiri->file_ktp)}}" target="_blank">Lihat File <i class="mdi mdi-eye"></i></a></td>
        </tr>
    </tbody>
</table>