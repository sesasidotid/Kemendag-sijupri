<?php

namespace App\Exports;

use App\Http\Controllers\AKP\Service\AkpService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class AkpExport implements FromCollection, WithMultipleSheets, WithEvents
{
    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function collection(): Collection
    {
        // You can implement the collection method here if needed.
        // For multiple sheets, you can leave this method empty.
        return collect([]);
    }

    public function sheets(): array
    {
        $akp = new AkpService();
        $akp = $akp->findById($this->id);
        $sheets = [];

        // Add logic to fetch AkpMatrix data for each sheet
        $sheets[] = new AkpMatrix1Sheet(1, $akp);
        $sheets[] = new AkpMatrix2Sheet(2, $akp);
        $sheets[] = new AkpMatrix3Sheet(3, $akp);
        $sheets[] = new RekapSheet(4, $akp);

        return $sheets;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $highestRow = $event->sheet->getHighestRow();
                for ($row = 1; $row <= $highestRow; $row++) {
                    if ($event->sheet->getCellByColumnAndRow(2, $row)->getValue() === '') {
                        $event->sheet->getDelegate()->mergeCells("A{$row}:D{$row}");
                    }
                }
            }
        ];
    }
}

class AkpMatrix1Sheet implements FromCollection, WithMapping, WithTitle
{
    protected $sheetNumber;
    protected $akp;

    public function title(): string
    {
        // Set the sheet name here
        return 'matrix_1';
    }

    public function __construct(int $sheetNumber, AkpService $akp)
    {
        $this->sheetNumber = $sheetNumber;
        $this->akp = $akp;
    }

    public function collection(): Collection
    {
        $akpMatrixData = [];

        $akpMatrices = $this->akp->akpMatrix;

        $akp_kategori_pertanyaan_id = 0;
        foreach ($akpMatrices as $akpMatrix) {
            $akp_kategori_pertanyaan_id_current = $akpMatrix->pertanyaanAKP->akp_kategori_pertanyaan_id;
            if ($akp_kategori_pertanyaan_id !== $akp_kategori_pertanyaan_id_current) {
                $akp_kategori_pertanyaan_id = $akp_kategori_pertanyaan_id_current;

                $akpMatrixData[] = ['kategori_h' => "Kategori"];

                $akpMatrixData[] = [
                    'kategori' => $akpMatrix->pertanyaanAKP->akpKategoriPertanyaan->kategori,
                ];

                $akpMatrixData[] = [
                    'pertanyaan_h' => 'pertanyaan',
                    'ybs_h' => 'ybs',
                    'atasan_h' => 'atasan',
                    'rekan_h' => 'rekan',
                    'dkk_h' => 'dkk',
                ];

                $akpMatrixData[] = [
                    'pertanyaan' => $akpMatrix->pertanyaanAKP->pertanyaan,
                    'ybs' => $akpMatrix->ybs,
                    'atasan' => $akpMatrix->atasan,
                    'rekan' => $akpMatrix->rekan,
                    'dkk' => $akpMatrix->keterangan_matrix_1,
                ];
            } else {
                $akpMatrixData[] = [
                    'pertanyaan' => $akpMatrix->pertanyaanAKP->pertanyaan,
                    'ybs' => $akpMatrix->ybs,
                    'atasan' => $akpMatrix->atasan,
                    'rekan' => $akpMatrix->rekan,
                    'dkk' => $akpMatrix->keterangan_matrix_1,
                ];
            }
        }

        return collect($akpMatrixData);
    }

    public function map($row): array
    {
        return $row;
    }
}

class AkpMatrix2Sheet implements FromCollection, WithMapping, WithTitle
{
    protected $sheetNumber;
    protected $akp;

    public function title(): string
    {
        // Set the sheet name here
        return 'matrix_2';
    }

    public function __construct(int $sheetNumber, AkpService $akp)
    {
        $this->sheetNumber = $sheetNumber;
        $this->akp = $akp;
    }

    public function collection(): Collection
    {
        $akpMatrixData = [];

        $akpMatrices = $this->akp->akpMatrix;

        $akp_kategori_pertanyaan_id = 0;
        foreach ($akpMatrices as $akpMatrix) {

            if ($akpMatrix->score_matrix_1 < 7) {
                $akp_kategori_pertanyaan_id_current = $akpMatrix->pertanyaanAKP->akp_kategori_pertanyaan_id;
                if ($akp_kategori_pertanyaan_id !== $akp_kategori_pertanyaan_id_current) {
                    $akp_kategori_pertanyaan_id = $akp_kategori_pertanyaan_id_current;


                    $akpMatrixData[] = ['kategori_h' => "Kategori"];

                    $akpMatrixData[] = [
                        'kategori' => $akpMatrix->pertanyaanAKP->akpKategoriPertanyaan->kategori,
                    ];

                    $akpMatrixData[] = [
                        'pertanyaan_h' => 'Pertanyaan',
                        'penugasan_h' => 'Penugasan',
                        'materi_h' => 'Materi',
                        'informasi_h' => 'Informasi',
                        'penyebab_diskrepansi_utama_h' => 'Penyebab Diskrepansi Utama',
                    ];

                    $akpMatrixData[] = [
                        'pertanyaan' => $akpMatrix->pertanyaanAKP->pertanyaan,
                        'penugasan' => $akpMatrix->penugasan,
                        'materi' => $akpMatrix->materi,
                        'informasi' => $akpMatrix->informasi,
                        'penyebab_diskrepansi_utama' => $akpMatrix->penyebab_diskrepansi_utama,
                    ];
                } else {
                    $akpMatrixData[] = [
                        'pertanyaan' => $akpMatrix->pertanyaanAKP->pertanyaan,
                        'penugasan' => $akpMatrix->penugasan,
                        'materi' => $akpMatrix->materi,
                        'informasi' => $akpMatrix->informasi,
                        'penyebab_diskrepansi_utama' => $akpMatrix->penyebab_diskrepansi_utama,
                    ];
                }
            }
        }

        return collect($akpMatrixData);
    }

    public function map($row): array
    {
        return $row;
    }
}

class AkpMatrix3Sheet implements FromCollection, WithMapping, WithTitle
{
    protected $sheetNumber;
    protected $akp;

    public function title(): string
    {
        // Set the sheet name here
        return 'matrix_3';
    }

    public function __construct(int $sheetNumber, AkpService $akp)
    {
        $this->sheetNumber = $sheetNumber;
        $this->akp = $akp;
    }

    public function collection(): Collection
    {
        $akpMatrixData = [];

        $akpMatrices = $this->akp->akpMatrix;

        $akp_kategori_pertanyaan_id = 0;
        foreach ($akpMatrices as $akpMatrix) {
            if ($akpMatrix->score_matrix_1 < 7) {
                $akp_kategori_pertanyaan_id_current = $akpMatrix->pertanyaanAKP->akp_kategori_pertanyaan_id;
                if ($akp_kategori_pertanyaan_id !== $akp_kategori_pertanyaan_id_current) {
                    $akp_kategori_pertanyaan_id = $akp_kategori_pertanyaan_id_current;


                    $akpMatrixData[] = ['kategori_h' => "Kategori"];

                    $akpMatrixData[] = [
                        'kategori' => $akpMatrix->pertanyaanAKP->akpKategoriPertanyaan->kategori,
                    ];

                    $akpMatrixData[] = [
                        'pertanyaan_h' => 'Pertanyaan',
                        'waktu_h' => 'Waktu',
                        'kesulitan_h' => 'Kesulitan',
                        'pengaruh_h' => 'Pengaruh',
                        'score_matrix_3_h' => 'score',
                        'kategori_matrix_3_h' => 'Kategori',
                        'rank_prioritas_matrix_3_h' => 'Rank Perioritas',
                    ];

                    $akpMatrixData[] = [
                        'pertanyaan' => $akpMatrix->pertanyaanAKP->pertanyaan,
                        'waktu' => $akpMatrix->waktu,
                        'kesulitan' => $akpMatrix->kesulitan,
                        'pengaruh' => $akpMatrix->pengaruh,
                        'score_matrix_3' => $akpMatrix->score_matrix_3,
                        'kategori_matrix_3' => $akpMatrix->kategori_matrix_3,
                        'rank_prioritas_matrix_3' => $akpMatrix->rank_prioritas_matrix_3,
                    ];
                } else {
                    $akpMatrixData[] = [
                        'pertanyaan' => $akpMatrix->pertanyaanAKP->pertanyaan,
                        'waktu' => $akpMatrix->waktu,
                        'kesulitan' => $akpMatrix->kesulitan,
                        'kualitas' => $akpMatrix->kualitas,
                        'pengaruh' => $akpMatrix->pengaruh,
                        'score_matrix_3' => $akpMatrix->score_matrix_3,
                        'kategori_matrix_3' => $akpMatrix->kategori_matrix_3,
                        'rank_prioritas_matrix_3' => $akpMatrix->rank_prioritas_matrix_3,
                    ];
                }
            }
        }

        return collect($akpMatrixData);
    }

    public function map($row): array
    {
        return $row;
    }
}

class RekapSheet implements FromCollection, WithMapping, WithTitle
{
    protected $sheetNumber;
    protected $akp;

    public function title(): string
    {
        // Set the sheet name here
        return 'rekap';
    }

    public function __construct(int $sheetNumber, AkpService $akp)
    {
        $this->sheetNumber = $sheetNumber;
        $this->akp = $akp;
    }

    public function collection(): Collection
    {
        $akpMatrixData = [];

        $akpMatrices = $this->akp->akpMatrix;

        $akp_kategori_pertanyaan_id = 0;
        foreach ($akpMatrices as $akpMatrix) {
            if ($akpMatrix->score_matrix_1 < 7) {
                $akp_kategori_pertanyaan_id_current = $akpMatrix->pertanyaanAKP->akp_kategori_pertanyaan_id;
                if ($akp_kategori_pertanyaan_id !== $akp_kategori_pertanyaan_id_current) {
                    $akp_kategori_pertanyaan_id = $akp_kategori_pertanyaan_id_current;


                    $akpMatrixData[] = ['kategori_h' => "Kategori"];

                    $akpMatrixData[] = [
                        'kategori' => $akpMatrix->pertanyaanAKP->akpKategoriPertanyaan->kategori,
                    ];

                    $akpMatrixData[] = [
                        'pertanyaan_h' => 'Pertanyaan',
                        'dkk_h' => 'dkk',
                        'rank_prioritas_matrix_3_h' => 'Rank Perioritas',
                        'kategori_matrix_3_h' => 'Kategori',
                        'pelatihan_h' => 'Jenis Pelatihan',
                    ];

                    $akpMatrixData[] = [
                        'pertanyaan' => $akpMatrix->pertanyaanAKP->pertanyaan,
                        'dkk' => $akpMatrix->keterangan_matrix_1,
                        'rank_prioritas_matrix_3' => $akpMatrix->rank_prioritas_matrix_3,
                        'kategori_matrix_3' => $akpMatrix->kategori_matrix_3,
                        'pelatihan' => $akpMatrix->akpPelatihan->name ?? '',
                    ];
                } else {
                    $akpMatrixData[] = [
                        'pertanyaan' => $akpMatrix->pertanyaanAKP->pertanyaan,
                        'dkk' => $akpMatrix->keterangan_matrix_1,
                        'rank_prioritas_matrix_3' => $akpMatrix->rank_prioritas_matrix_3,
                        'kategori_matrix_3' => $akpMatrix->kategori_matrix_3,
                        'pelatihan' => $akpMatrix->akpPelatihan->name ?? '',
                    ];
                }
            }
        }

        return collect($akpMatrixData);
    }

    public function map($row): array
    {
        return $row;
    }
}
