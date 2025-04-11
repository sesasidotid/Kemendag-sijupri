<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Dtos\UkomFormulaDto;
use Eyegil\SijupriUkom\Models\UkomFormula;
use Illuminate\Support\Facades\DB;

class UkomFormulaService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->searchHas(UkomFormula::class, ["jabatan", "jenjang"]);
    }

    public function findById($id): UkomFormula
    {
        return UkomFormula::findOrThrowNotFound($id);
    }

    public function update(UkomFormulaDto $ukomFormulaDto)
    {
        return DB::transaction(function () use ($ukomFormulaDto) {
            $userContext = user_context();

            $ukomFormula = $this->findById($ukomFormulaDto->id);
            $ukomFormula->cat_percentage = $ukomFormulaDto->cat_percentage;
            $ukomFormula->wawancara_percentage = $ukomFormulaDto->wawancara_percentage;
            $ukomFormula->seminar_percentage = $ukomFormulaDto->seminar_percentage;
            $ukomFormula->praktik_percentage = $ukomFormulaDto->praktik_percentage;
            $ukomFormula->ukt_percentage = $ukomFormulaDto->ukt_percentage;
            $ukomFormula->ukmsk_percentage = $ukomFormulaDto->ukmsk_percentage;
            $ukomFormula->grade_threshold = $ukomFormulaDto->grade_threshold;
            $ukomFormula->portofolio_percentage = $ukomFormulaDto->portofolio_percentage;
            $ukomFormula->ukt_threshold = $ukomFormulaDto->ukt_threshold;
            $ukomFormula->jpm_threshold = $ukomFormulaDto->jpm_threshold;
            $ukomFormula->created_by = $userContext->id;
            $ukomFormula->save();

            return $ukomFormula;
        });
    }
}
