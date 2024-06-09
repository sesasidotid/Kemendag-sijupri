<div class="row">
    <div class="card" id="applicationList">
        <div class="card-header bg-light border-0">
            <h5 class="card-title mb-md-0 flex-grow-1">
                Opd/Unit Kerja {{ $unitKerja->name }} ({{ $unitKerja->operasional }})
            </h5>
        </div>
        <div class="card-body justify-content-start d-print-none">
            @if (isset($unitKerja->instansi->provinsi))
                <div class="hstack gap-2">
                    <div style="width: 10%">Provinsi</div>
                    <div>:</div>
                    <div>{{ $unitKerja->instansi->provinsi->name }}</div>
                </div>
            @endif
            @if (isset($unitKerja->instansi->kabupaten))
                <div class="hstack gap-2 mt-2">
                    <div style="width: 10%">Kabupaten</div>
                    <div>:</div>
                    <div>{{ $unitKerja->instansi->kabupaten->name }}</div>
                </div>
            @endif
            @if (isset($unitKerja->instansi->kota))
                <div class="hstack gap-2 mt-2">
                    <div style="width: 10%">Kota</div>
                    <div>:</div>
                    <div>{{ $unitKerja->instansi->kota->name }}</div>
                </div>
            @endif
            <div class="hstack gap-2 mt-2">
                <div style="width: 10%">Email</div>
                <div>:</div>
                <div>{{ $unitKerja->email ?? '-' }}</div>
            </div>
            <div class="hstack gap-2 mt-2">
                <div style="width: 10%">Kota</div>
                <div>:</div>
                <div>{{ $unitKerja->phone ?? '-' }}</div>
            </div>
            <div class="hstack gap-2 mt-2">
                <div style="width: 10%">Kota</div>
                <div>:</div>
                <div>{{ $unitKerja->alamat ?? '-' }}</div>
            </div>
        </div>
    </div><!--end row-->
    <div class="card" id="applicationList">
        <div class="card-header bg-light border-0">
            <h5 class="card-title mb-md-0 flex-grow-1">
                Data Formasi
            </h5>
        </div>
        <div class="col-xxl-12">
            @if (isset($isDokumenVerified))
                @if (!$isDokumenVerified)
                    @include('formasi.task.dokumen')
                @else
                    @if ($isUpdateForm)
                        @include('formasi.task.update')
                    @else
                        @include('formasi.task.formasi')
                    @endif
                @endif
            @endif
            @include('widget.modal-doc')
        </div><!--end col-->
    </div><!--end row-->
</div>
