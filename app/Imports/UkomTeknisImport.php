<?php

namespace App\Imports;

use App\Enums\UkomStatus;
use App\Http\Controllers\Ukom\Service\UkomService;
use App\Models\Ukom\UkomTeknis;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class UkomTeknisImport implements OnEachRow
{
    private $ukom_periode_id;
    private $header;

    public function __construct($ukom_periode_id)
    {
        $this->ukom_periode_id = $ukom_periode_id;
    }

    public function onRow(Row $row)
    {
        $rowArray = $row->toArray();

        if ($row->getIndex() === 1) {
            $this->header = $rowArray;
            return;
        }

        DB::transaction(function () use ($rowArray) {
            $userContext = auth()->user();

            $ukom = new UkomService();

            $ukomTeknis = new UkomTeknis();
            $ukomTeknis->created_by = $userContext->nip;
            $ukomTeknis->cat = $rowArray[1];
            $ukomTeknis->wawancara = $rowArray[2];
            $ukomTeknis->seminar = $rowArray[3];
            $ukomTeknis->praktik = $rowArray[4];

            $ukom = $ukom->findByUkomPeriodeIdAndNipOrEmail($this->ukom_periode_id, $rowArray[0]);
            $data = $ukom->hitungHasilAkhirV2($ukom, $ukomTeknis);
            $ukomTeknis->fill($data);
            $ukomTeknis->save();

            $ukom->ukom_teknis_id = $ukomTeknis->id;
            $ukom->status = UkomStatus::SELESAI;
            $ukom->customUpdate();
        });
    }
}
