<?php

namespace Eyegil\SijupriAkp\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriAkp\Dtos\KategoriInstrumentDto;
use Eyegil\SijupriAkp\Dtos\PertanyaanDto;
use Eyegil\SijupriAkp\Models\Pertanyaan;
use Illuminate\Support\Facades\DB;

class PertanyaanService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(Pertanyaan::class);
    }

    public function findById($id)
    {
        return Pertanyaan::findOrThrowNotFound($id);
    }

    public function findAll()
    {
        return Pertanyaan::all();
    }

    public function save(KategoriInstrumentDto $kategoriInstrumentDto)
    {
        return DB::transaction(function () use ($kategoriInstrumentDto) {
            $userContext = user_context();
            foreach ($kategoriInstrumentDto->pertanyaan_list as $key => $pertanyaan_dto) {
                $pertanyaanDto = (new PertanyaanDto())->fromArray((array) $pertanyaan_dto)->validateSave();

                $pertanyaan = new Pertanyaan();
                $pertanyaan->name = $pertanyaanDto->name;
                $pertanyaan->kategori_instrument_id = $kategoriInstrumentDto->id;
                $pertanyaan->created_by = $userContext->id;
                $pertanyaan->save();
            }
        });
    }

    public function update(KategoriInstrumentDto $kategoriInstrumentDto)
    {
        return DB::transaction(function () use ($kategoriInstrumentDto) {
            $userContext = user_context();

            $this->delete($kategoriInstrumentDto->id);
            foreach ($kategoriInstrumentDto->pertanyaan_list as $key => $pertanyaan_dto) {
                $pertanyaanDto = (new PertanyaanDto())->fromArray((array) $pertanyaan_dto)->validateUpdate();

                $pertanyaan = null;
                if (isset($pertanyaanDto->id) && $pertanyaanDto->id) {
                    $pertanyaan = $this->findById($pertanyaanDto->id);
                } else {
                    $pertanyaan = new Pertanyaan();
                }
                $pertanyaan->name = $pertanyaanDto->name;
                $pertanyaan->updated_by = $userContext->id;
                $pertanyaan->kategori_instrument_id = $kategoriInstrumentDto->id;
                $pertanyaan->delete_flag = false;
                $pertanyaan->save();
            }
        });
    }

    public function delete($kategori_instrument_id)
    {
        return DB::transaction(function () use ($kategori_instrument_id) {
            $userContext = user_context();
            Pertanyaan::where('kategori_instrument_id', $kategori_instrument_id)->update([
                'delete_flag' => true,
                'updated_by' => $userContext->id,
            ]);
        });
    }
}
