<?php

namespace App\Http\Controllers\Formasi\Service;

use App\Http\Controllers\SearchService;
use App\Models\Formasi\Formasi;
use App\Models\Formasi\FormasiScore;
use App\Models\Formasi\FormasiUnsur;
use Illuminate\Support\Facades\DB;

class FormasiScoreService extends FormasiScore
{
    use SearchService;

    public function findAll()
    {
        $this->where('delete_flag', false)->get();
    }

    public function findById($code)
    {
        $this
            ->where('code', $code)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByFormasiId($formasi_id)
    {
        return $this
            ->where('formasi_id', $formasi_id)
            ->get();
    }

    public function findByFormasiIdAndFormasiUnsurId($formasi_id, $formasi_unsur_id): ?FormasiScore
    {
        return $this
            ->where('formasi_id', $formasi_id)
            ->where('formasi_unsur_id', $formasi_unsur_id)
            ->first();
    }

    public function saveByFormasiUnsur(FormasiUnsur $formasiUnsur, $formasi_id, $volume)
    {
        $formasiScore = $this->findByFormasiIdAndFormasiUnsurId($formasi_id, $formasiUnsur->id);
        if ($formasiScore) {
            $formasiScore->fill($formasiUnsur->toArray());
            $formasiScore->formasi_unsur_id = $formasiUnsur->id;
            $formasiScore->formasi_id = $formasi_id;
            $formasiScore->volume = $volume;
            $formasiScore->score = ($formasiUnsur->standart_waktu * (int)$volume) / 60 / 1250;

            $formasiScore->customUpdate();
        } else {
            $this->fill($formasiUnsur->toArray());
            $this->formasi_unsur_id = $formasiUnsur->id;
            $this->formasi_id = $formasi_id;
            $this->volume = $volume;
            $this->score = ($formasiUnsur->standart_waktu * (int)$volume) / 60 / 1250;

            $this->customSave();
        }
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
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->save();
        });
    }

    public function customDelete()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->delete_flag = true;
            $this->save();
        });
    }
}
