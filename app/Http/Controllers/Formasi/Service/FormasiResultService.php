<?php

namespace App\Http\Controllers\Formasi\Service;

use App\Http\Controllers\SearchService;
use App\Models\Formasi\FormasiResult;
use Illuminate\Support\Facades\DB;

class FormasiResultService extends FormasiResult
{
    use SearchService;

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($code)
    {
        return $this->where('code', $code)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByFormasiId($formasi_id)
    {
        return $this->where('formasi_id', $formasi_id)
            ->get();
    }

    public function findByFormasiIdAndJenjangCode($formasi_id, $jenjang_code)
    {
        return $this
            ->where('formasi_id', $formasi_id)
            ->where('jenjang_code', $jenjang_code)
            ->first();
    }

    public function customSaveAll(array $formasiResultNew)
    {
        DB::transaction(function () use ($formasiResultNew) {
            foreach ($formasiResultNew as $key => $value) {
                if ($value['jenjang_code']) {
                    $formasiResult = $this->findByFormasiIdAndJenjangCode($value['formasi_id'], $value['jenjang_code']);
                    if ($formasiResult) {
                        $formasiResult->fill($value);
                        $formasiResult->customUpdate();
                    } else {
                        $formasiResult = new FormasiResultService();
                        $formasiResult->fill($value);
                        $formasiResult->customSave();
                    }
                }
            }
        });
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->save();
        });
    }

    public function customUpdate()
    {
        $userContext = auth()->user();

        $this->updated_by = $userContext->nip;
        $this->save();
    }

    public function customDelete()
    {
        $userContext = auth()->user();

        $this->updated_by = $userContext->nip;
        $this->delete_flag = true;
        $this->save();
    }
}
