<?php

namespace Eyegil\SijupriAkp\Services;

use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\PelatihanTeknisDto;
use Eyegil\SijupriMaintenance\Models\PelatihanTeknis;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AkpPelatihanTeknisService
{
    const type = "akp";

    public function __construct(
        private InstrumentService $instrumentService,
        private KategoriInstrumentService $kategoriInstrumentService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual("type", $this::type);
        $pageable->addEqual("delete_flag", false);
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PelatihanTeknis::class);
    }

    public function findById($id)
    {
        return PelatihanTeknis::findOrThrowNotFound($id);
    }

    public function findByCode($code)
    {
        return PelatihanTeknis::where("code", $code)->where("type", $this::type)->where('delete_flag', false)->first();
    }

    public function findByInstrumentId($instrument_id)
    {
        $instrument = $this->instrumentService->findById($instrument_id);
        $jabatan_code = $instrument->jabatanJenjang->jabatan_code;
        return PelatihanTeknis::where("jabatan_code", $jabatan_code)->where("type", $this::type)->where('delete_flag', false)->get();
    }

    public function save(PelatihanTeknisDto $pleatihanTeknisDto)
    {
        return DB::transaction(function () use ($pleatihanTeknisDto) {
            $userContext = user_context();
            if ($this->findByCode($pleatihanTeknisDto->code)) throw new RecordExistException("Code already exist");


            $pelatihanTeknis = new PelatihanTeknis();
            $pelatihanTeknis->fromArray($pleatihanTeknisDto->toArray());
            $pelatihanTeknis->type = $this::type;
            $pelatihanTeknis->created_by = $userContext->id;
            $pelatihanTeknis->saveWithUUid();

            return $pelatihanTeknis;
        });
    }

    public function update(PelatihanTeknisDto $pleatihanTeknisDto)
    {
        return DB::transaction(function () use ($pleatihanTeknisDto) {
            $userContext = user_context();

            $pelatihanTeknis = $this->findById($pleatihanTeknisDto->id);
            if ($pelatihanTeknis->code != $pleatihanTeknisDto->code && $this->findByCode($pleatihanTeknisDto->code)) throw new RecordExistException("Code already exist");
            $pelatihanTeknis = $this->findById($pleatihanTeknisDto->id);
            $pelatihanTeknis->updated_by = $userContext->id;
            $pelatihanTeknis->name = $pleatihanTeknisDto->name;
            $pelatihanTeknis->code = $pleatihanTeknisDto->code;
            $pelatihanTeknis->save();

            return $pelatihanTeknis;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $pelatihanTeknis = $this->findById($id);

            $pelatihanTeknis->updated_by = $userContext->id;
            $pelatihanTeknis->delete_flag = true;
            $pelatihanTeknis->save();
            $this->kategoriInstrumentService->removePelatihanTeknisId($pelatihanTeknis->id);

            return $pelatihanTeknis;
        });
    }
}
