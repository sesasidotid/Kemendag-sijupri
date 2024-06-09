<?php

namespace App\Exports;

use App\Models\Ukom\Ukom;
use App\Models\Ukom\UkomMansoskul;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class UkomMansoskulExport implements FromCollection, WithHeadings, WithMapping
{
    private $ukom_periode_id;

    public function __construct($ukom_periode_id)
    {
        $this->ukom_periode_id = $ukom_periode_id;
    }

    public function collection()
    {
        return UkomMansoskul::where(function ($query) {
            $query->whereHas("ukom", function (Builder $query) {
                $query->where("ukom_periode_id", '=', $this->ukom_periode_id);
            });
        });
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Integritas',
            'Kerjasama',
            'Komunikasi',
            'Orientasi Hasil',
            'Pelayanan Publik',
            'Pengembangan Diri Orang Lain',
            'Mengelola Perubahan',
            'Pengambilan Keputusan',
            'Perekat Bangsa',
            'Score',
            'JPM',
            'Kategori',
        ];
    }

    public function map($ukomMansoskul): array
    {
        return [
            $ukomMansoskul->ukom->nip,
            $ukomMansoskul->integritas,
            $ukomMansoskul->kerjasama,
            $ukomMansoskul->komunikasi,
            $ukomMansoskul->orientasi_hasil,
            $ukomMansoskul->pelayanan_publik,
            $ukomMansoskul->pengembangan_diri_orang_lain,
            $ukomMansoskul->mengelola_perubahan,
            $ukomMansoskul->pengambilan_keputusan,
            $ukomMansoskul->perekat_bangsa,
            $ukomMansoskul->score,
            $ukomMansoskul->jpm,
            $ukomMansoskul->kategori,
        ];
    }
}
