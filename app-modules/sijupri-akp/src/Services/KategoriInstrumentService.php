<?php

namespace Eyegil\SijupriAkp\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriAkp\Dtos\KategoriInstrumentDto;
use Eyegil\SijupriAkp\Models\KategoriInstrument;
use Illuminate\Support\Facades\DB;

class KategoriInstrumentService
{
    public function __construct(
        private PertanyaanService $pertanyaanService
    ) {}

    public function findSearch(Pageable $pageable)
    {
        return $pageable->with(['instrument'])->searchHas(KategoriInstrument::class, ['instrument']);
    }

    public function findById($id)
    {
        return KategoriInstrument::with("pertanyaanList")->findOrThrowNotFound($id);
    }

    public function findByPelatihanTeknisCode($pelatihan_teknis_id)
    {
        return KategoriInstrument::where('pelatihan_teknis_id', $pelatihan_teknis_id)->get();
    }

    public function findAll()
    {
        return KategoriInstrument::with('instrument')->get();
    }

    public function save(KategoriInstrumentDto $kategoriInstrumentDto)
    {
        return DB::transaction(function () use ($kategoriInstrumentDto) {
            $userContext = user_context();
            $kategoriInstrument = new KategoriInstrument();
            $kategoriInstrument->fromArray($kategoriInstrumentDto->toArray());
            $kategoriInstrument->created_by = $userContext->id;
            $kategoriInstrument->save();

            $kategoriInstrumentDto->id = $kategoriInstrument->id;
            $this->pertanyaanService->save($kategoriInstrumentDto);
        });
    }

    public function update(KategoriInstrumentDto $kategoriInstrumentDto)
    {
        return DB::transaction(function () use ($kategoriInstrumentDto) {
            $userContext = user_context();
            $kategoriInstrument = $this->findById($kategoriInstrumentDto->id);
            $kategoriInstrument->fromArray($kategoriInstrumentDto->toArray());
            $kategoriInstrument->updated_by = $userContext->id;
            $kategoriInstrument->save();

            $this->pertanyaanService->update($kategoriInstrumentDto);
        });
    }

    public function removePelatihanTeknisId($pelatihan_teknis_id)
    {
        return DB::transaction(function () use ($pelatihan_teknis_id) {
            return KategoriInstrument::where('pelatihan_teknis_id', $pelatihan_teknis_id)->update([
                "pelatihan_teknis_id" => null
            ]);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $kategoriInstrument = $this->findById($id);

            $kategoriInstrument->updated_by = $userContext->id;
            $kategoriInstrument->delete_flag = true;
            $kategoriInstrument->save();

            $this->pertanyaanService->delete($id);

            return $kategoriInstrument;
        });
    }
}
