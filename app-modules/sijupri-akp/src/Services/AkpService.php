<?php

namespace Eyegil\SijupriAkp\Services;

use App\Services\SendNotifyService;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\Base\Pageable;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\NotificationBase\Services\NotificationService;
use Eyegil\SijupriAkp\Dtos\AkpDto;
use Eyegil\SijupriAkp\Dtos\AkpRekapDto;
use Eyegil\SijupriAkp\Dtos\AkpReviewerDto;
use Eyegil\SijupriAkp\Dtos\KategoriInstrumentDto;
use Eyegil\SijupriAkp\Dtos\Matrix1Dto;
use Eyegil\SijupriAkp\Dtos\Matrix2Dto;
use Eyegil\SijupriAkp\Dtos\Matrix3Dto;
use Eyegil\SijupriAkp\Dtos\MatrixDto;
use Eyegil\SijupriAkp\Dtos\PertanyaanDto;
use Eyegil\SijupriAkp\Enums\AkpFlow;
use Eyegil\SijupriAkp\Enums\JenisPengembanganKompetensi;
use Eyegil\SijupriAkp\Enums\KategoriDiskrepansi;
use Eyegil\SijupriAkp\Enums\Matrix1Keterangan;
use Eyegil\SijupriAkp\Enums\PenyebabDiskrepansiUtama;
use Eyegil\SijupriAkp\Models\Akp;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Google\Cloud\Core\Exception\NotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AkpService
{
    public function __construct(
        private KategoriInstrumentService $kategoriInstrumentService,
        private PertanyaanService $pertanyaanService,
        private MatrixService $matrixService,
        private WorkflowService $workflowService,
        private SendNotifyService $sendNotifyService
    ) {}

    public function findById($id): Akp
    {
        return Akp::findOrThrowNotFound($id);
    }

    public function findSearch(Pageable $pageable)
    {
        $userContext = user_context();
        if (in_array($userContext->application_code, ["sijupri-internal", "sijupri-external"])) {
            $pageable->addEqual("nip", $userContext->id);
        }
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(Akp::class);
    }

    public function save(AkpDto $akpDto)
    {
        return DB::transaction(function () use ($akpDto) {
            $akp = new Akp();
            $akp->fromArray($akpDto->toArray());
            $akp->inactive_flag = true;
            $akp->save();

            $this->matrixService->save($akpDto);

            return $akpDto;
        });
    }

    public function getAkpForReviewer($reviewer, $id)
    {
        $pendingTask = $this->workflowService->findTaskByWorkflowNameAndObjectId("akp_task", $id);
        $akpDto = new AkpDto();
        $akpDto->fromArray((array) $pendingTask->objectTask->object);
        if ($reviewer == "atasan" && $akpDto->is_atasan_graded) {
            return ["status" => "FINISHED"];
        } else  if ($reviewer == "rekan" && $akpDto->is_rekan_graded) {
            return ["status" => "FINISHED"];
        }

        $akpReviewrDto = new AkpReviewerDto();
        $akpReviewrDto->fromArray($akpDto->toArray());

        $kategori_instrument_temp = [];
        foreach ($akpDto->matrix_dto_list as $key => $matrix_dto) {
            $matrixDto = (new MatrixDto())->fromArray((array) $matrix_dto);

            if (!in_array($matrixDto->kategori_instrument_id, $kategori_instrument_temp)) {
                $kategori_instrument_temp[] = $matrixDto->kategori_instrument_id;

                $kategoriInstrumentDto = new KategoriInstrumentDto();
                $kategoriInstrument = $this->kategoriInstrumentService->findById($matrixDto->kategori_instrument_id);
                unset($kategoriInstrument->pertanyaanList);
                $kategoriInstrumentDto->fromModel($kategoriInstrument);

                $kategori_instrument_list[] = $kategoriInstrumentDto;
            }

            $pertanyaanDto = new PertanyaanDto();
            $pertanyaanDto->fromModel($this->pertanyaanService->findById($matrixDto->pertanyaan_id));
            $kategori_instrument_list[count($kategori_instrument_list) - 1]->pertanyaan_list[] = $pertanyaanDto;
        }

        $akpReviewrDto->kategori_instrument_list = $kategori_instrument_list;

        return $akpReviewrDto;
    }

    public function getAkpForPersonal($id)
    {
        $pendingTask = $this->workflowService->findTaskByWorkflowNameAndObjectId("akp_task", $id);
        $akpDto = new AkpDto();
        $akpDto->fromArray((array) $pendingTask->objectTask->object);

        $akpReviewrDto = new AkpReviewerDto();
        $akpReviewrDto->fromArray($akpDto->toArray());

        $kategori_instrument_temp = [];
        $data_pertanyaan_list = [];
        $kategoriInstrumentTemp = null;
        foreach ($akpDto->matrix_dto_list as $key => $matrix_dto) {
            $matrixDto = (new MatrixDto())->fromArray((array) $matrix_dto);

            if (!in_array($matrixDto->kategori_instrument_id, $kategori_instrument_temp)) {
                $kategori_instrument_temp[] = $matrixDto->kategori_instrument_id;
                $kategoriInstrumentTemp = $this->kategoriInstrumentService->findById($matrixDto->kategori_instrument_id);
            }

            $data_pertanyaan_list[] = [
                "kategori_instrument_id" => $kategoriInstrumentTemp->id,
                "kategori_instrument_name" => $kategoriInstrumentTemp->name,
                "pertanyaan_id" => $matrixDto->pertanyaan_id,
                "pertanyaan_name" => $matrixDto->pertanyaan_name,
                "nilai_ybs" => $matrixDto->matrix1_dto->nilai_ybs ?? 0,
                "nilai_rekan" => $matrixDto->matrix1_dto->nilai_rekan ?? 0,
                "nilai_atasan" => $matrixDto->matrix1_dto->nilai_atasan ?? 0,
            ];
        }

        $akpReviewrDto->data_pertanyaan_list = $data_pertanyaan_list;

        return $akpReviewrDto;
    }

    public function saveMatrixAtasan(AkpDto $akpDto)
    {
        DB::transaction(function () use ($akpDto) {
            $pendingTask = $this->workflowService->findTaskByWorkflowNameAndObjectId("akp_task", $akpDto->id);
            $taskObject = new AkpDto();
            $taskObject->fromArray((array) $pendingTask->objectTask->object);
            if ($taskObject->is_atasan_graded) {
                throw new RecordNotFoundException("Not Found");
            } else {
                $taskObject->is_atasan_graded = true;
            }

            $matrix1_dto_list_lookup = [];
            foreach ($akpDto->matrix1_dto_list as $key => $matrix1_dto) {
                $matrix1Dto = (new Matrix1Dto())->fromArray((array) $matrix1_dto);
                $matrix1_dto_list_lookup[$matrix1Dto->pertanyaan_id] = [
                    'data' => $matrix1Dto,
                    'key' => $key
                ];
            }

            foreach ($taskObject->matrix_dto_list as $key => $matrix_dto) {
                $matrixDto = (new MatrixDto())->fromArray((array) $matrix_dto);
                $matrix1Dto = $matrix1_dto_list_lookup[$matrixDto->pertanyaan_id]["data"];

                if (!in_array((int) $matrix1Dto->nilai_atasan, [1, 2, 3]))
                    throw new BusinessException("Not acceptable value | only [1, 2, 3]", "AKP-00001");

                if ($matrixDto->matrix1_dto)
                    $matrixDto->matrix1_dto->nilai_atasan = $matrix1Dto->nilai_atasan;
                else
                    $matrixDto->matrix1_dto = $matrix1Dto;

                $matrixDto->matrix1_dto->pertanyaan_id = $matrixDto->pertanyaan_id;
                $matrixDto->matrix1_dto->pertanyaan_name = $matrixDto->pertanyaan_name;
                $matrixDto->matrix1_dto->score = ((int) $matrixDto->matrix1_dto->nilai_ybs ?? 0) + ((int) $matrixDto->matrix1_dto->nilai_rekan ?? 0) + ((int) $matrixDto->matrix1_dto->nilai_atasan ?? 0);
                if ((int) $matrixDto->matrix1_dto->score <= 3) $matrixDto->matrix1_dto->keterangan = Matrix1Keterangan::DKK;
                else if ((int) $matrixDto->matrix1_dto->score <= 6) $matrixDto->matrix1_dto->keterangan = Matrix1Keterangan::DKK_NON_TRAINING;
                else if ((int) $matrixDto->matrix1_dto->score <= 7) $matrixDto->matrix1_dto->keterangan = Matrix1Keterangan::NON_DKK;
                $taskObject->matrix_dto_list[$key] = $matrixDto;
            }

            $task_action = ($taskObject->is_atasan_graded && $taskObject->is_rekan_graded) ? "approve" : "amend";
            $this->workflowService->submitTask(
                $pendingTask->id,
                $task_action,
                $taskObject,
            );

            if ($task_action == "approve") {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyPenilaianPersonalAkp($notificationDto, $taskObject->nip);
            }
        });
    }

    public function saveMatrixRekan(AkpDto $akpDto)
    {
        DB::transaction(function () use ($akpDto) {
            $pendingTask = $this->workflowService->findTaskByWorkflowNameAndObjectId("akp_task", $akpDto->id);
            $taskObject = new AkpDto();
            $taskObject->fromArray((array) $pendingTask->objectTask->object);
            if ($taskObject->is_rekan_graded) {
                throw new RecordNotFoundException("Not Found");
            } else {
                $taskObject->is_rekan_graded = true;
            }

            $matrix1_dto_list_lookup = [];
            foreach ($akpDto->matrix1_dto_list as $key => $matrix1_dto) {
                $matrix1Dto = (new Matrix1Dto())->fromArray((array) $matrix1_dto);
                $matrix1_dto_list_lookup[$matrix1Dto->pertanyaan_id] = [
                    'data' => $matrix1Dto,
                    'key' => $key
                ];
            }

            foreach ($taskObject->matrix_dto_list as $key => $matrix_dto) {
                $matrixDto = (new MatrixDto())->fromArray((array) $matrix_dto);
                $matrix1Dto = $matrix1_dto_list_lookup[$matrixDto->pertanyaan_id]["data"];

                if (!in_array((int) $matrix1Dto->nilai_rekan, [1, 2, 3]))
                    throw new BusinessException("Not acceptable value | only [1, 2, 3]", "AKP-00001");

                if ($matrixDto->matrix1_dto)
                    $matrixDto->matrix1_dto->nilai_rekan = $matrix1Dto->nilai_rekan;
                else
                    $matrixDto->matrix1_dto = $matrix1Dto;

                $matrixDto->matrix1_dto->pertanyaan_id = $matrixDto->pertanyaan_id;
                $matrixDto->matrix1_dto->pertanyaan_name = $matrixDto->pertanyaan_name;
                $matrixDto->matrix1_dto->score = ((int) $matrixDto->matrix1_dto->nilai_ybs ?? 0) + ((int) $matrixDto->matrix1_dto->nilai_rekan ?? 0) + ((int) $matrixDto->matrix1_dto->nilai_atasan ?? 0);
                if ((int) $matrixDto->matrix1_dto->score <= 3) $matrixDto->matrix1_dto->keterangan = Matrix1Keterangan::DKK;
                else if ((int) $matrixDto->matrix1_dto->score <= 6) $matrixDto->matrix1_dto->keterangan = Matrix1Keterangan::DKK_NON_TRAINING;
                else if ((int) $matrixDto->matrix1_dto->score <= 7) $matrixDto->matrix1_dto->keterangan = Matrix1Keterangan::NON_DKK;
                $taskObject->matrix_dto_list[$key] = $matrixDto;
            }

            $task_action = ($taskObject->is_atasan_graded && $taskObject->is_rekan_graded) ? "approve" : "amend";
            $this->workflowService->submitTask(
                $pendingTask->id,
                $task_action,
                $taskObject,
            );

            if ($task_action == "approve") {
                $notificationDto = new NotificationDto();
                $this->sendNotifyService->notifyPenilaianPersonalAkp($notificationDto, $taskObject->nip);
            }
        });
    }

    public function saveMatrixYbs(AkpDto $akpDto)
    {
        DB::transaction(function () use ($akpDto) {
            $pendingTask = $this->workflowService->findTaskByWorkflowNameAndObjectId("akp_task", $akpDto->id);
            if ($pendingTask->flow_id != AkpFlow::FLOW_3->value) {
                throw new RecordNotFoundException("task not found");
            }

            $taskObject = new AkpDto();
            $taskObject->fromArray((array) $pendingTask->objectTask->object);
            if ($pendingTask->flow_id != AkpFlow::FLOW_3->value) {
                throw new NotFoundException("Akp Not found");
            }

            $matrix1_dto_list_lookup = [];
            foreach ($akpDto->matrix1_dto_list as $key => $matrix1_dto) {
                $matrix1Dto = (new Matrix1Dto())->fromArray((array) $matrix1_dto);
                $matrix1_dto_list_lookup[$matrix1Dto->pertanyaan_id] = [
                    'data' => $matrix1Dto,
                    'key' => $key
                ];
            }

            $matrix2_dto_list_lookup = [];
            foreach ($akpDto->matrix2_dto_list as $key => $matrix2_dto) {
                $matrix2Dto = (new Matrix2Dto())->fromArray((array) $matrix2_dto);
                $matrix2_dto_list_lookup[$matrix2Dto->pertanyaan_id] = [
                    'data' => $matrix2Dto,
                    'key' => $key
                ];
            }

            $matrix3_dto_list_lookup = [];
            foreach ($akpDto->matrix3_dto_list as $key => $matrix3_dto) {
                $matrix3Dto = (new Matrix3Dto())->fromArray((array) $matrix3_dto);
                $matrix3_dto_list_lookup[$matrix3Dto->pertanyaan_id] = [
                    'data' => $matrix3Dto,
                    'key' => $key
                ];
            }

            foreach ($taskObject->matrix_dto_list as $key => $matrix_dto) {
                $matrixDto = (new MatrixDto())->fromArray((array) $matrix_dto);
                $matrix1Dto = $matrix1_dto_list_lookup[$matrixDto->pertanyaan_id]["data"];

                //matix 1
                if (!in_array((int) $matrix1Dto->nilai_ybs, [1, 2, 3]))
                    throw new BusinessException("Not acceptable value | only [1, 2, 3]", "AKP-00001");


                $matrixDto->matrix1_dto->nilai_ybs = $matrix1Dto->nilai_ybs;
                $matrixDto->matrix1_dto->pertanyaan_id = $matrixDto->pertanyaan_id;
                $matrixDto->matrix1_dto->pertanyaan_name = $matrixDto->pertanyaan_name;
                $matrixDto->matrix1_dto->score = ((int) $matrixDto->matrix1_dto->nilai_ybs ?? 0) + ((int) $matrixDto->matrix1_dto->nilai_rekan ?? 0) + ((int) $matrixDto->matrix1_dto->nilai_atasan ?? 0);

                //matrix2
                $matrix2Dto = $matrix2_dto_list_lookup[$matrixDto->pertanyaan_id]["data"] ?? null;
                $matrix3Dto = $matrix3_dto_list_lookup[$matrixDto->pertanyaan_id]["data"] ?? null;

                if ($matrix2Dto && $matrix3Dto) {
                    $matrixDto->matrix2_dto = $matrix2Dto;
                    $matrixDto->matrix2_dto->pertanyaan_id = $matrixDto->pertanyaan_id;
                    $matrixDto->matrix2_dto->pertanyaan_name = $matrixDto->pertanyaan_name;
                    $matrixDto->matrix2_dto->score = ((int) $matrixDto->matrix2_dto->nilai_penugasan ?? 0) + ((int) $matrixDto->matrix2_dto->nilai_materi ?? 0) + ((int) $matrixDto->matrix2_dto->nilai_informasi ?? 0) + ((int) $matrixDto->matrix2_dto->nilai_standar ?? 0) + ((int) $matrixDto->matrix2_dto->nilai_metode ?? 0);

                    $matrixDto->matrix3_dto = $matrix3Dto;
                    $matrixDto->matrix3_dto->pertanyaan_id = $matrixDto->pertanyaan_id;
                    $matrixDto->matrix3_dto->pertanyaan_name = $matrixDto->pertanyaan_name;
                    $matrixDto->matrix3_dto->score = ((int) $matrixDto->matrix3_dto->nilai_waktu ?? 0) + ((int) $matrixDto->matrix3_dto->nilai_kesulitan ?? 0) + ((int) $matrixDto->matrix3_dto->nilai_kualitas ?? 0) + ((int) $matrixDto->matrix3_dto->nilai_pengaruh ?? 0);


                    $akpRekapDto = new AkpRekapDto();
                    $akpRekapDto->pertanyaan_id = $matrixDto->pertanyaan_id;
                    $akpRekapDto->pertanyaan_name = $matrixDto->pertanyaan_name;

                    if ((int) $matrixDto->matrix1_dto->score <= 3) $akpRekapDto->keterangan = Matrix1Keterangan::DKK;
                    else if ((int) $matrixDto->matrix1_dto->score <= 6) $akpRekapDto->keterangan = Matrix1Keterangan::DKK_NON_TRAINING;
                    else if ((int) $matrixDto->matrix1_dto->score <= 7) $akpRekapDto->keterangan = Matrix1Keterangan::NON_DKK;

                    if ((int) $matrixDto->matrix2_dto->nilai_informasi == 1) {
                        $akpRekapDto->penyebab_diskrepansi_utama = PenyebabDiskrepansiUtama::INFORMASI->value;
                        $akpRekapDto->jenis_pengembangan_kompetensi = JenisPengembanganKompetensi::MANDIRI->value;
                    } else if ((int) $matrixDto->matrix2_dto->nilai_penugasan == 1) {
                        $akpRekapDto->penyebab_diskrepansi_utama = PenyebabDiskrepansiUtama::PENUNJANG_KEGIATAN->value;
                        $akpRekapDto->jenis_pengembangan_kompetensi = JenisPengembanganKompetensi::MAGANG->value;
                    } else if ((int) $matrixDto->matrix2_dto->nilai_materi == 1) {
                        $kategoriInstrumen = $this->kategoriInstrumentService->findById($matrixDto->kategori_instrument_id);
                        $pelatihanTeknis = $kategoriInstrumen->pelatihanTeknis;

                        $akpRekapDto->penyebab_diskrepansi_utama = PenyebabDiskrepansiUtama::PENUGASAN_MATERI->value;
                        $akpRekapDto->jenis_pengembangan_kompetensi = JenisPengembanganKompetensi::PELATIAN->value;

                        $akpRekapDto->pelatihan_teknis_id = $pelatihanTeknis->id;
                        $akpRekapDto->pelatihan_teknis_name = $pelatihanTeknis->name;
                    }

                    if ($matrixDto->matrix3_dto->score <= 9) $akpRekapDto->kategori = KategoriDiskrepansi::DISKREPANSI_TINGGI->name;
                    else if ($matrixDto->matrix3_dto->score <= 14) $akpRekapDto->kategori = KategoriDiskrepansi::DISKREPANSI_SENDANG->name;
                    else if ($matrixDto->matrix3_dto->score <= 25) $akpRekapDto->kategori = KategoriDiskrepansi::DISKREPANSI_RENDAH->name;

                    $matrixDto->akp_rekap_dto = $akpRekapDto;
                }

                $taskObject->matrix_dto_list[$key] = $matrixDto;
            }

            $taskObject->matrix_dto_list = $this->calculateRanks($taskObject->matrix_dto_list);

            $task = $this->workflowService->submitTask(
                $pendingTask->id,
                "approve",
                $taskObject
            );

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                if ($task->task_action == "approve") {
                    $akpDto = new AkpDto();
                    $akpDto->fromArray((array) $task->objectTask->object);
                    return $this->save($akpDto);
                } else {
                    throw new RecordNotFoundException("task action not found");
                }
            } else {
                throw new BusinessException("Something went wrong", "");
            }
        });
    }

    public function updateRekomendasi(AkpDto $akpDto)
    {
        return DB::transaction(function () use ($akpDto) {
            $userContext = user_context();

            $akp = $this->findById($akpDto->id);
            $akp->rekomendasi = $akpDto->rekomendasi;
            $akp->updated_by = $userContext->id;
            $akp->save();

            return $akp;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $this->findById($id)->delete();
        });
    }

    private function calculateRanks($matrix_dto_list)
    {
        usort($matrix_dto_list, function ($a, $b) {
            if ($a->akp_rekap_dto && $b->akp_rekap_dto)
                return $a->matrix3_dto->score <=> $b->matrix3_dto->score;
            else if ($a->akp_rekap_dto)
                return $a->matrix3_dto->score <=> 0;
            else if ($b->akp_rekap_dto)
                return 0 <=> $b->matrix3_dto->score;
        });

        $rank = 1;
        $prevScore = null;
        foreach ($matrix_dto_list as &$item) {
            if ($item->akp_rekap_dto) {
                if ($prevScore !== null && $item->matrix3_dto->score === $prevScore) {
                    $item->akp_rekap_dto->rank_prioritas = $rank - 1;
                } else {
                    $item->akp_rekap_dto->rank_prioritas = $rank;
                }
                $prevScore = $item->matrix3_dto->score;
                $rank++;
            }
        }

        return $matrix_dto_list;
    }

    public function sendNotifyAtasan(NotificationDto $notificationDto)
    {
        $notificationDto = new NotificationDto();
        $notificationDto->subject = "Penilaian AKP";

        // $this->notificationService->sendWithTemplate("smtp", SMTPTemplateCode::NOTIFY_AKP_ATASAN->value, $notificationDto);
    }
}
