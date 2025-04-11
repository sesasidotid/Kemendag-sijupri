<?php

namespace Eyegil\SijupriFormasi\Services;

use Eyegil\SijupriFormasi\Dtos\UnsurDto;
use Eyegil\SijupriFormasi\Models\Unsur;

class UnsurService
{

    public function findById($id)
    {
        return Unsur::findOrThrowNotFound($id);
    }

    public function findByJabatanCode($jabatan_code)
    {
        return Unsur::where("jabatan_code", $jabatan_code)
            ->where("delete_flag", false)
            ->where("parent_id", null)
            ->get();
    }

    public function findByJabatanCodeAndJenjangCodeNotNull($jabatan_code)
    {
        return Unsur::where("jabatan_code", $jabatan_code)
            ->where("delete_flag", false)
            ->whereNotNull("jenjang_code")
            ->get();
    }

    public function findUnsurTree($jabatan_code)
    {
        $unsurList = $this->findByJabatanCode($jabatan_code);
        $unsurTreeDto = [];
        $this->toTree($unsurTreeDto, $unsurList);
        return $unsurTreeDto;
    }

    private function toTree(&$unsurTreeDto, $unsurList)
    {
        foreach ($unsurList as $key => $value) {
            $unsurDto = new UnsurDto();
            $unsurDto->fromArray($value->toArray());

            $unsurChild = $value->child;
            if ($unsurChild && count($unsurChild) > 0) {
                $unsurChildDto = [];
                $this->toTree($unsurChildDto, $unsurChild);
                $unsurDto->child = $unsurChildDto;
            }

            if ($value->jenjang_code)
                $unsurDto->jenjang_name = $value->jenjang->name;
            $unsurTreeDto[] = $unsurDto;
        }
    }
}
