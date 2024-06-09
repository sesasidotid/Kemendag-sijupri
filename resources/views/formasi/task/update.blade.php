<div>
    <link href="{{ asset('starter/float/dist/mfb.css') }}" rel="stylesheet">

    <script src="{{ asset('starter/float/src/mfb.js') }}"></script>
    <div class="p-2" style="border-radius: 10px">
        <form wire:submit.prevent="store">
            @csrf
            <div class="row">
                <div class="text-center text-dark h6 col">Unsur</div>
                <div class="text-center text-dark h6 col-2">Volume <br> (Inputan Pertahun)</div>
                <div class="text-center text-dark h6 col-1">Jenjang</div>
            </div>
            <hr class="bg-dark">
            @include('formasi.task._unsur', ['child' => $formasiUnsurList])
            <ul id="menu" class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
                <li class="mfb-component__wrap">
                    <div class="btn-group " role="group" aria-label="Basic example">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <a wire:click="$set('isUpdateForm', {{ !$isUpdateForm }})"
                                    class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-secondary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </form>
        <link rel="stylesheet" href="{{ asset('auth/ef.css') }}">
    </div>
</div>
