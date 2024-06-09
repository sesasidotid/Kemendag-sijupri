<?php

namespace App\Imports;

use App\Http\Controllers\Ukom\Service\UkomService;
use App\Models\Ukom\UkomMansoskul;
use App\Models\Ukom\UkomNilai;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class UkomMansoskulImport implements OnEachRow
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

            $ukomMansoskul = UkomMansoskul::create([
                'created_by' => $userContext->nip,
                'integritas' => $rowArray[1],
                'kerjasama' => $rowArray[2],
                'komunikasi' => $rowArray[3],
                'orientasi_hasil' => $rowArray[4],
                'pelayanan_publik' => $rowArray[5],
                'pengembangan_diri_orang_lain' => $rowArray[6],
                'mengelola_perubahan' => $rowArray[7],
                'pengambilan_keputusan' => $rowArray[8],
                'perekat_bangsa' => $rowArray[9],
                'score' => $rowArray[10],
                'jpm' => $rowArray[11],
                'kategori' => $rowArray[12],
            ]);

            $ukom = new UkomService();
            $ukom = $ukom->findByUkomPeriodeIdAndNipOrEmail($this->ukom_periode_id, $rowArray[0]);
            $ukom->ukom_mansoskul_id = $ukomMansoskul->id;
            $ukom->customUpdate();
        });
    }
}
