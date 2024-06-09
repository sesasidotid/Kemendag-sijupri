<?php

namespace App\Exports;

use App\Http\Controllers\Siap\Service\UnitKerjaService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UnitKerjaFormasiExport implements FromCollection, WithHeadings, WithMapping
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $unitKerja = new UnitKerjaService();
        // Assuming findById() returns a collection or array
        return $unitKerja->findById($this->id)->formasi;
    }

    public function headings(): array
    {
        return [
            'Jabatan',
            'Pemula',
            'Terampil',
            'Mahir',
            'Penyelia',
            'Pertama',
            'Muda',
            'Madya',
            'Utama',
            'Total',
        ];
    }

    public function map($formasi): array
    {
        // Map each formasi of data
        $data = [
            $formasi->jabatan->name,
            "0", "0", "0", "0", "0", "0", "0", "0",
            $formasi->total_result ?? "0"
        ];
        foreach ($formasi->formasiResult as $key => $formasiResult) {
            switch ($formasiResult->jenjang_code) {
                case 'pemula':
                    $data[1] = $formasiResult->result ?? "0";
                    break;
                case 'terampil':
                    $data[2] = $formasiResult->result ?? "0";
                    break;
                case 'mahir':
                    $data[3] = $formasiResult->result ?? "0";
                    break;
                case 'penyelia':
                    $data[4] = $formasiResult->result ?? "0";
                    break;
                case 'pertama':
                    $data[5] = $formasiResult->result ?? "0";
                    break;
                case 'muda':
                    $data[6] = $formasiResult->result ?? "0";
                    break;
                case 'madya':
                    $data[7] = $formasiResult->result ?? "0";
                    break;
                case 'utama':
                    $data[8] = $formasiResult->result ?? "0";
                    break;
                default:
                    break;
            }
        }
        return $data;
    }
}
