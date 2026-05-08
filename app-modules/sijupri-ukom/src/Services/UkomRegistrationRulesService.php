<?php

namespace Eyegil\SijupriUkom\Services;

use DB;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Dtos\UkomRegistrationRulesDto;
use Eyegil\SijupriUkom\Models\UkomRegistrationRules;
use Illuminate\Database\Eloquent\Builder;
use Eyegil\Base\Exceptions\RecordExistException;

class UkomRegistrationRulesService
{

    public function findSearch(Pageable $pageable, $searchParams = [])
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })
            ->setJoinQueries(function (Pageable $instance, Builder $query) {
                $query->leftJoin('mnt_jenjang', 'ukm_registration_rules.jenjang_code', '=', 'mnt_jenjang.code')
                    ->leftJoin('mnt_rating_kinerja as rk_hasil', 'ukm_registration_rules.rating_hasil_id', '=', 'rk_hasil.id')
                    ->leftJoin('mnt_rating_kinerja as rk_kinerja', 'ukm_registration_rules.rating_kinerja_id', '=', 'rk_kinerja.id')
                    ->leftJoin('mnt_predikat_kinerja', 'ukm_registration_rules.predikat_kinerja_id', '=', 'mnt_predikat_kinerja.id');
            }, true)
            ->setWhereQueries(function (Pageable $instance, Builder $query) {
                $query->when($searchParams['eq_jenjang_code'] ?? null, function ($q, $value) {
                    $q->where('eq_jenjang_code', $value);
                });

                $query->when($searchParams['eq_jenis_ukom'] ?? null, function ($q, $value) {
                    $q->where('eq_jenis_ukom', $value);
                });

                $query->when($searchParams['eq_angka_kredit_threshold'] ?? null, function ($q, $value) {
                    $q->where('eq_angka_kredit_threshold', $value);
                });

                $query->when($searchParams['eq_last_n_year'] ?? null, function ($q, $value) {
                    $q->where('eq_last_n_year', $value);
                });

                $query->when($searchParams['ratineq_g_hasil_id'] ?? null, function ($q, $value) {
                    $q->where('rating_hasil_id', $value);
                });

                $query->when($searchParams['eq_rating_kinerja_id'] ?? null, function ($q, $value) {
                    $q->where('eq_rating_kinerja_id', $value);
                });

                $query->when($searchParams['eq_predikat_kinerja_id'] ?? null, function ($q, $value) {
                    $q->where('eq_predikat_kinerja_id', $value);
                });
            }, true)
            ->search(UkomRegistrationRules::class);
    }

    public function findById($id)
    {
        return UkomRegistrationRules::findOrThrowNotFound($id);
    }

    public function findByJenjangCode($jenjang_code)
    {
        return UkomRegistrationRules::where("jenjang_code", $jenjang_code)->first();
    }

    public function findByJenjangCodeAndJenisUkom($jenjang_code, $jenis_ukom)
    {
        return UkomRegistrationRules::where("jenjang_code", $jenjang_code)
            ->where("jenis_ukom", $jenis_ukom)
            ->first();
    }

    public function save(UkomRegistrationRulesDto $ukomRegistrationRulesDto)
    {
        return DB::transaction(function () use ($ukomRegistrationRulesDto) {
            if ($this->findByJenjangCodeAndJenisUkom($ukomRegistrationRulesDto->jenjang_code, $ukomRegistrationRulesDto->jenis_ukom)) {
                throw new RecordExistException("Ukom Registration Rules with jenjang_code {$ukomRegistrationRulesDto->jenjang_code} and jenis_ukom {$ukomRegistrationRulesDto->jenis_ukom} already exists");
            }

            $ukomRegistrationRules = new UkomRegistrationRules();
            $ukomRegistrationRules->fromArray($ukomRegistrationRulesDto->toArray());
            $ukomRegistrationRules->saveWithUUid();
            return $ukomRegistrationRules;
        });
    }

    public function update(UkomRegistrationRulesDto $ukomRegistrationRulesDto)
    {
        return DB::transaction(function () use ($ukomRegistrationRulesDto) {
            $ukomRegistrationRules = $this->findById($ukomRegistrationRulesDto->id);
            $ukomRegistrationRules->angka_kredit_threshold = $ukomRegistrationRulesDto->angka_kredit_threshold;
            $ukomRegistrationRules->last_n_year = $ukomRegistrationRulesDto->last_n_year;
            $ukomRegistrationRules->tmt_last_n_year = $ukomRegistrationRulesDto->tmt_last_n_year ?? 0;
            $ukomRegistrationRules->rating_hasil_id = $ukomRegistrationRulesDto->rating_hasil_id;
            $ukomRegistrationRules->rating_kinerja_id = $ukomRegistrationRulesDto->rating_kinerja_id;
            $ukomRegistrationRules->predikat_kinerja_id = $ukomRegistrationRulesDto->predikat_kinerja_id;
            $ukomRegistrationRules->save();
            return $ukomRegistrationRules;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $ukomRegistrationRules = $this->findById($id);
            $ukomRegistrationRules->delete();
        });
    }
}
