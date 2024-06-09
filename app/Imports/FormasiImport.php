<?php
// app/Imports/FormasiImport.php

namespace App\Imports;

use App\Enums\TaskStatus;
use App\Models\Formasi\Formasi;
use App\Models\Formasi\FormasiResult;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class FormasiImport implements OnEachRow
{
    private $header;

    public function onRow(Row $row)
    {
        $rowArray = $row->toArray();

        // Skip the header row
        if ($row->getIndex() === 1) {
            $this->header = $rowArray;
            return;
        }

        // Validate jabatan_code against tbl_jabatan
        $jabatanCode = $rowArray[2] ?? null; // Assuming jabatan_code is the third column

        $exists = DB::table('tbl_jabatan')->where('code', $jabatanCode)->exists();

        if (!$exists) {
            throw ValidationException::withMessages([
                'jabatan_code' => 'Invalid jabatan_code: ' . $jabatanCode,
            ]);
        }

        // Continue with the import
        $formasi = Formasi::create([
            'unit_kerja_id' => (int)$rowArray[0],
            'jabatan_code' => $jabatanCode,
            'total' => (int)$rowArray[3],
            'inactive_flag' => true,
            'task_status' => TaskStatus::PENDING,
        ]);
        try {
            for ($i = 4; $i < count($rowArray); $i++) {
                FormasiResult::create([
                    'formasi_id' => $formasi->id,
                    'pembulatan' => (int)$rowArray[$i],
                    'jenjang_code' => $this->header[$i],
                    'sdm' => 0,
                    'total' => 0
                ]);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
