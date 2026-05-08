<?php

namespace Eyegil\SijupriSiap\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Converters\RiwayatKinerjaConverter;
use Eyegil\SijupriSiap\Dtos\RiwayatKinerjaDto;
use Eyegil\SijupriSiap\Models\RiwayatKinerja;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;

class RiwayatKinerjaService
{
    public function __construct(
        private StorageService $storageService,
    ) {
    }

    public function findSearch(Pageable $pageable)
    {
        $userContext = user_context();
        if ($userContext->application_code == "sijupri-internal" || $userContext->application_code == "sijupri-external") {
            $pageable->addEqual("nip", $userContext->id);
        }
        return $pageable->with(['jf'])->search(RiwayatKinerja::class);
    }

    public function findByDateStartAndDateEnd($date_start, $date_end)
    {
        RiwayatKinerja::where("date_start", $date_start)
            ->where("date_end", $date_end)
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->first();
    }

    public function findById($id): RiwayatKinerja
    {
        return RiwayatKinerja::find($id);
    }

    public function findByNip($nip)
    {
        return RiwayatKinerja::where("nip", $nip)
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->get();
    }

    public function findByNipAndLastNYearList($nip, $yearRange)
    {
        return RiwayatKinerja::where("nip", $nip)
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->where("type", "tahunan")
            ->whereBetween("date_start", [
                now()->copy()->startOfYear()->subYears((int) $yearRange),
                now()->copy()->subYear()->endOfYear(),
            ])
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date_start)->format('Y');
            })
            ->map(function ($group) {
                return $group->sortByDesc('date_start')->first();
            })
            ->sortByDesc(fn($item) => $item->date_start)
            ->values();
    }

    public function findByNipAndLastNYear($nip, $yearRange)
    {
        return RiwayatKinerja::where("nip", $nip)
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->where("type", "tahunan")
            ->whereBetween("date_start", [
                now()->copy()->startOfYear()->subYears((int) $yearRange),
                now()->copy()->subYear()->endOfYear(),
            ])
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date_start)->format('Y');
            })
            ->map(function ($group) {
                return $group->sortByDesc('date_start')->first();
            })
            ->sortByDesc(fn($item) => $item->date_start)
            ->values()
            ->map(function ($riwayatKinerja) {
                $riwayatKinerjaDto = RiwayatKinerjaConverter::toDto($riwayatKinerja);
                if ($riwayatKinerja->doc_evaluasi) {
                    $riwayatKinerjaDto->doc_evaluasi_url = $this->storageService->getUrl("system", "jf", $riwayatKinerja->doc_evaluasi);
                }
                if ($riwayatKinerja->doc_predikat) {
                    $riwayatKinerjaDto->doc_predikat_url = $this->storageService->getUrl("system", "jf", $riwayatKinerja->doc_predikat);
                }
                if ($riwayatKinerja->doc_akumulasi_ak) {
                    $riwayatKinerjaDto->doc_akumulasi_ak_url = $this->storageService->getUrl("system", "jf", $riwayatKinerja->doc_akumulasi_ak);
                }
                if ($riwayatKinerja->doc_penetapan_ak) {
                    $riwayatKinerjaDto->doc_penetapan_ak_url = $this->storageService->getUrl("system", "jf", $riwayatKinerja->doc_penetapan_ak);
                }

                return $riwayatKinerjaDto;
            });
    }

    public function current()
    {
        $userContext = user_context();
        return RiwayatKinerja::where($userContext->id)->latest('date_end')->firstOrThrowNotFound();
    }

    public function save(RiwayatKinerjaDto $riwayatKinerjaDto)
    {
        return DB::transaction(function () use ($riwayatKinerjaDto) {
            $userContext = user_context();
            $riwayatKinerja = new RiwayatKinerja();
            $riwayatKinerja->created_by = $userContext->id;
            $riwayatKinerja->fromArray($riwayatKinerjaDto->toArray());
            $riwayatKinerja->saveWithUUid();

            return $riwayatKinerja;
        });
    }

    public function update(RiwayatKinerjaDto $riwayatKinerjaDto)
    {
        return DB::transaction(function () use ($riwayatKinerjaDto) {
            $userContext = user_context();
            $riwayatKinerja = $this->findById($riwayatKinerjaDto->id);

            $riwayatKinerja->updated_by = $userContext->id;

            if ($riwayatKinerjaDto->doc_akumulasi_ak != $riwayatKinerja->doc_akumulasi_ak) {
                $this->storageService->deleteObject("system", "jf", $riwayatKinerja->doc_akumulasi_ak);
            }
            if ($riwayatKinerjaDto->doc_penetapan_ak != $riwayatKinerja->doc_penetapan_ak) {
                $this->storageService->deleteObject("system", "jf", $riwayatKinerja->doc_penetapan_ak);
            }
            if ($riwayatKinerjaDto->doc_evaluasi != $riwayatKinerja->doc_evaluasi) {
                $this->storageService->deleteObject("system", "jf", $riwayatKinerja->doc_evaluasi);
            }
            if ($riwayatKinerjaDto->doc_predikat != $riwayatKinerja->doc_predikat) {
                $this->storageService->deleteObject("system", "jf", $riwayatKinerja->doc_predikat);
            }

            $riwayatKinerja->fromArray($riwayatKinerjaDto->toArray());
            $riwayatKinerja->save();

            return $riwayatKinerja;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $riwayatKinerja = $this->findById($id);

            $riwayatKinerja["updated_by"] = $userContext->id;
            $riwayatKinerja["delete_flag"] = true;
            $riwayatKinerja->save();

            return $riwayatKinerja;
        });
    }
}
