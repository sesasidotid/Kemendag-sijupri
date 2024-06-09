<div>
    <link href="{{ asset('starter/float/dist/mfb.css') }}" rel="stylesheet">

    <script src="{{ asset('starter/float/src/mfb.js') }}"></script>
    <div class="p-2" style="border-radius: 10px">
        <form wire:submit.prevent="store">
            @csrf
            @if ($formasiData->task_status == 'PENDING')
                <input type="text" class="form-control w-100 is-valid text-success bg-white p-3 m-3" disabled
                    value="Menunggu Verifikasi">
            @endif
            <div class="row">
                <div class="text-center text-dark h6 col">Unsur</div>
                <div class="text-center text-dark h6 col-2">Volume <br> (Inputan Pertahun)</div>
                <div class="text-center text-dark h6 col-1">Jenjang</div>
            </div>
            <hr class="bg-dark">
            @include('formasi.jabatan._unsur', [
                'child' => $formasiUnsurList,
                'formasi_id' => $formasiData->id,
            ])
            @if ($formasiData->task_status != 'PENDING')
                <ul id="menu" class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
                    <li class="mfb-component__wrap">
                        <div class="btn-group " role="group" aria-label="Basic example">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            @endif
        </form>
        <link rel="stylesheet" href="{{ asset('auth/ef.css') }}">
    </div>
</div>
