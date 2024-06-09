<?php

namespace App\Exports;

use App\Models\Ukom\Ukom;
use App\Models\Ukom\UkomTeknis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class UkomTeknisExport implements FromCollection, WithHeadings, WithMapping
{
    private $ukom_periode_id;

    public function __construct($ukom_periode_id)
    {
        $this->ukom_periode_id = $ukom_periode_id;
    }

    public function collection()
    {
        return UkomTeknis::where(function ($query) {
            $query->whereHas("ukom", function (Builder $query) {
                $query->where("ukom_periode_id", '=', $this->ukom_periode_id);
            });
        });
    }

    public function headings(): array
    {
        return [
            'NIP',
            'CAT',
            'Wawancara',
            'Seminar',
            'Praktik'
        ];
    }

    public function map($ukomTekni): array
    {
        return [
            $ukomTekni->ukom->nip,
            $ukomTekni->cat,
            $ukomTekni->wawancara,
            $ukomTekni->seminar,
            $ukomTekni->praktik,
        ];
    }
}
