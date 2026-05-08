<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Models\PendingTask;
use Eyegil\WorkflowBase\Models\ProcessInstance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ParticipantUkomService
{
    public function __construct(
        private DocumentUkomService $documentUkomService,
        private StorageService $storageService,
    ) {
    }

    public function findSearch(Pageable $pageable)
    {
        // remove filter inactive flag
        // $pageable->addEqual("inactive_flag", false);

        $pageable->addEqual("delete_flag", false);
        return $pageable->with(['user', 'ukomBan'])->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->searchHas(ParticipantUkom::class, ['user', 'ukomBan']);
    }

    public function findSearchByNip(Pageable $pageable, $nip)
    {
        $pageable->addEqual("nip", $nip);
        $pageable->addEqual("delete_flag", false);
        return $pageable->with(['user'])->searchHas(ParticipantUkom::class, ['user']);
    }

    public function findAllByNip($nip)
    {
        return ParticipantUkom::where('nip', $nip)->get();
    }

    public function findById($id)
    {
        return ParticipantUkom::findOrThrowNotFound($id);
    }

    public function findByUserId($user_id)
    {
        return ParticipantUkom::where("user_id", $user_id)
            ->where("inactive_flag", false)
            ->first();
    }

    public function findByNipOrEmailLatest($user_id_or_email)
    {
        return ParticipantUkom::where(function ($query) use ($user_id_or_email) {
            $query->where("nip", $user_id_or_email)
                ->orWhere("email", $user_id_or_email);
        })->latest("date_created")->first();
    }

    public function findByNipOrEmail($user_id_or_email)
    {
        return ParticipantUkom::where(function ($query) use ($user_id_or_email) {
            $query->where("nip", $user_id_or_email)
                ->orWhere("email", $user_id_or_email);
        })->where("inactive_flag", false)
            ->where("delete_flag", false)
            ->first();
    }

    public function findByRoomId($room_id)
    {
        return ParticipantRoomUkom::with("participantUkom")->where("room_id", $room_id)
            ->where("inactive_flag", false)
            ->where("delete_flag", false)
            ->get();
    }

    public function findLatestByNip($nip)
    {
        return ParticipantUkom::where('nip', $nip)
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->latest("date_created")->firstOrThrowNotFound();
    }

    public function save(ParticipantUkomDto $participantUkomDto): ParticipantUkom
    {
        return DB::transaction(function () use ($participantUkomDto) {
            $userContext = user_context();

            ParticipantUkom::where('nip', $participantUkomDto->nip)->update(['inactive_flag' => true]);

            $participantUkom = new ParticipantUkom();
            $participantUkom->fromArray($participantUkomDto->toArray());
            $participantUkom->created_by = $userContext->id;
            $participantUkom->id = $participantUkomDto->id;
            $participantUkom->save();

            $participantUkomDto->id = $participantUkom->id;
            $this->documentUkomService->save($participantUkomDto);

            return $participantUkom;
        });
    }

    public function uploadRekomendasiUkom(ParticipantUkomDto $participantUkomDto)
    {
        DB::transaction(function () use ($participantUkomDto) {
            $participantUkom = $this->findById($participantUkomDto->id);
            $participantUkom->rekomendasi = $this->storageService->putObjectFromBase64WithFilename("system", "ukom", "file_rekomendasi_" . $participantUkomDto->id, $participantUkomDto->file_rekomendasi);

            $participantUkom->save();
        });
    }

    public function uploadRekomendasiUkomBatch($compressed_file_base64)
    {
        DB::transaction(function () use ($compressed_file_base64) {

            // temp unique file name
            $compressed_file_base64 = preg_replace('#^data:.*?;base64,#', '', $compressed_file_base64);

            // temp unique file name
            $rarFileName = Str::uuid() . '.rar';
            $rarFilePath = storage_path('app/temp/' . $rarFileName);
            $extractPath = storage_path('app/temp/extracted_' . Str::uuid());

            try {
                // decode base64
                $rarData = base64_decode($compressed_file_base64);

                // ensure temp dir exists
                if (!file_exists(storage_path('app/temp'))) {
                    mkdir(storage_path('app/temp'), 0777, true);
                }

                // save .rar temporarily
                file_put_contents($rarFilePath, $rarData);
                Log::info('Rar file saved to: ' . $rarFilePath);

                // extract
                mkdir($extractPath, 0777, true);

                // use unrar (server must have unrar installed)
                $command = "unrar x -y " . escapeshellarg($rarFilePath) . " " . escapeshellarg($extractPath);
                shell_exec($command);

                // move pdfs
                $files = glob($extractPath . '/*.pdf');
                $destinationPath = storage_path('app/buckets/ukom');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                foreach ($files as $file) {
                    $filename = basename($file);
                    Log::info('' . $filename);
                    $participantUkom = $this->findByNipOrEmailLatest(str_replace('.pdf', '', $filename));
                    if (!$participantUkom) {
                        continue;
                    }

                    $participantUkom->rekomendasi = "file_rekomendasi_" . $participantUkom->id . ".pdf";
                    $participantUkom->save();

                    rename($file, $destinationPath . '/' . $participantUkom->rekomendasi);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'RAR extracted and PDFs saved.',
                    'pdf_count' => count($files)
                ]);
            } catch (\Throwable $th) {
                throw $th;
            } finally {
                if (file_exists($rarFilePath)) {
                    unlink($rarFilePath);
                }
                $this->deleteDir($extractPath);
            }
        });
    }

    public function updateRekomendasi($nip, $rekomendasi)
    {
        return DB::transaction(function () use ($nip, $rekomendasi) {
            $userContext = user_context();

            $participantUkom = $this->findLatestByNip($nip);
            $participantUkom->rekomendasi = $rekomendasi;
            $participantUkom->updated_by = $userContext->id;
            $participantUkom->save();

            return $participantUkom;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $this->findById($id)->delete();
            $pendingTaskList = PendingTask::where("object_id", $id)->where("workflow_id", "approvalUkom")->get();
            $instance_id = null;
            foreach ($pendingTaskList as $key => $pendingTask) {
                if (!$instance_id) {
                    $instance_id = $pendingTask->instance_id;
                }
                $objectTask = $pendingTask->objectTask();
                $pendingTask->delete();
                $objectTask->delete();
            }
            if ($instance_id) {
                ProcessInstance::where("id", $instance_id)->delete();
            }
        });
    }

    public function deleteByNip($nip)
    {
        DB::transaction(function () use ($nip) {
            $this->findLatestByNip($nip)->delete();
        });
    }

    private function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return;
        }
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                $filePath = $dirPath . DIRECTORY_SEPARATOR . $object;
                if (is_dir($filePath)) {
                    $this->deleteDir($filePath);
                } else {
                    unlink($filePath);
                }
            }
        }
        rmdir($dirPath);
    }
}
