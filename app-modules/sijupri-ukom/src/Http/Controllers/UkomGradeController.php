<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\EncriptionKey;
use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Converters\UkomGradeConverter;
use Eyegil\SijupriUkom\Dtos\UkomGradeDto;
use Eyegil\SijupriUkom\Dtos\UkomModuleQuestionDto;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Eyegil\SijupriUkom\Services\UkomGradeService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/ukom_grade")]
class UkomGradeController
{
    public function __construct(
        private UkomGradeService $ukomGradeService,
        private StorageService $storageService,
    ) {
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $search = $this->ukomGradeService->findSearch(new Pageable($request->query()));
        return $search->setCollection($search->getCollection()->map(function (UkomGrade $ukomGrade) {
            $ukomGradeDto = UkomGradeConverter::toDto($ukomGrade);
            $participantUkom = $ukomGrade->participantUkom;

            if ($participantUkom && $participantUkom->rekomendasi) {
                $ukomGradeDto->rekomendasi = $participantUkom->rekomendasi;
                $ukomGradeDto->rekomendasi_url = $this->storageService->getUrl("system", "ukom", $participantUkom->rekomendasi);
            }

            return $ukomGradeDto;
        }));
    }

    #[Get("/participant/{participant_id}")]
    public function findByParticipantId($participant_id)
    {
        return $this->ukomGradeService->findByParticipantId($participant_id);
    }

    #[Get("/participant")]
    public function findByParticipantIdWithKey(Request $request)
    {
        if (!$request->query->has('key'))
            throw new BusinessException("Parameter Key not found", "UKM-00004");
        $encriptionKey = new EncriptionKey($request->query("key"));

        $data = $encriptionKey->validate();
        if (!$data)
            throw new BusinessException("key not valid", "PASS-00001");
        $participant_ukom_id = $data->participant_ukom_id;

        return $this->ukomGradeService->findByParticipantId($participant_ukom_id);
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return UkomGradeConverter::toDto($this->ukomGradeService->findById($id));
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        $this->ukomGradeService->delete($id);
    }

    #[Post("/publish_all")]
    public function publishAll()
    {
        $this->ukomGradeService->publishAll();
    }
}
