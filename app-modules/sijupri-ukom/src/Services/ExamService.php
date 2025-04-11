<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\Base\Pageable;
use Eyegil\EyegilLms\Dtos\MultipleChoiceDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\EyegilLms\Models\MultipleChoice;
use Eyegil\EyegilLms\Models\Question;
use Eyegil\EyegilLms\Services\AnswerService;
use Eyegil\EyegilLms\Services\QuestionService;
use Eyegil\SijupriUkom\Dtos\ExamAttendanceDto;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\StorageBase\Services\StorageService;
use Google\Cloud\Core\Exception\NotFoundException;
use Illuminate\Support\Facades\DB;

class ExamService
{

    public function __construct(
        private QuestionService $questionService,
        private StorageService $storageService,
        private AnswerService $answerService,
        private ExamAttendanceService $examAttendanceService,
        private ExamScheduleService $examScheduleService,
        private ExamGradeService $examGradeService,
        private ExamQuestionService $examQuestionService
    ) {}

    public function getExamPage($exam_type_code, $room_ukom_id, $page = 1, $limit = 10)
    {
        $userContext = user_context();
        $this->validateAttendance($exam_type_code, $room_ukom_id, $userContext->getDetails("participant_id"));

        $search = ExamQuestion::with(["question", "question.choices"])
            ->where("exam_type_code", $exam_type_code)
            ->where("room_ukom_id", $room_ukom_id)
            ->orderByRaw("MD5(CONCAT(id::text, ?::text, ?::text))", [$userContext->id, Carbon::now()->format('Ymd')])
            ->paginate($limit, ['*'], 'page', $page);

        return $search->setCollection($search->getCollection()->map(function (ExamQuestion $examQuestion) use ($userContext) {
            $question = $examQuestion->question;

            $questionDto = (new QuestionDto())->fromModel($question);
            if ($question->attachment != null) {
                $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
            }

            if ($question->choices) {
                $questionDto->multiple_choice_dto_list = $question->choices->map(function (MultipleChoice $multipleChoice) {
                    $multipleChoiceDto = (new MultipleChoiceDto())->fromModel($multipleChoice);
                    $multipleChoiceDto->correct = null;
                    return $multipleChoiceDto;
                });
            }

            $answer = $this->answerService->findByQuestionIdAndParticipantId($question->id, $userContext->getDetails("participant_id"));
            if ($answer) {
                $questionDto->answer_dto = (new AnswerDto())->fromModel($answer);
            }

            return $questionDto;
        }));
    }

    public function start($exam_type_code, $room_ukom_id)
    {
        DB::transaction(function () use ($exam_type_code, $room_ukom_id) {

            $examSchedule = $this->examScheduleService->findByExamTypeCodeAndRoomUkomId($exam_type_code, $room_ukom_id);
            if (Carbon::now()->lessThan(Carbon::parse($examSchedule->start_time))) {
                throw new BusinessException("Exam's not yet started", "");
            }

            if (Carbon::now()->greaterThan(Carbon::parse($examSchedule->end_time))) {
                throw new BusinessException("Exam's already ended", "");
            }

            $userContext = user_context();

            if (!$this->examAttendanceService->findByExamTypeCodeAndRoomUkomIdAndParticipantId(
                $exam_type_code,
                $room_ukom_id,
                $userContext->getDetails("participant_id")
            )) {
                $examAttendanceDto = new ExamAttendanceDto();
                $examAttendanceDto->participant_ukom_id = $userContext->getDetails("participant_id");
                $examAttendanceDto->room_ukom_id = $room_ukom_id;
                $examAttendanceDto->exam_type_code = $exam_type_code;
                $examAttendanceDto->start_at = Carbon::now();

                $this->examAttendanceService->save($examAttendanceDto);
            }
        });
    }

    public function finish($exam_type_code, $room_ukom_id)
    {
        DB::transaction(function () use ($exam_type_code, $room_ukom_id) {
            $userContext = user_context();
            $this->validateAttendance($exam_type_code, $room_ukom_id, $userContext->getDetails("participant_id"));

            $examAttendanceDto = new ExamAttendanceDto();
            $examAttendanceDto->participant_ukom_id = $userContext->getDetails("participant_id");
            $examAttendanceDto->room_ukom_id = $room_ukom_id;
            $examAttendanceDto->exam_type_code = $exam_type_code;
            $examAttendanceDto->finish_at = Carbon::now();

            $this->examAttendanceService->update($examAttendanceDto);

            $examQuestionList = $this->examQuestionService->findByExamTypeCodeAndRoomUkomId(
                $exam_type_code,
                $room_ukom_id
            );

            if (ExamTypes::CAT->value == $exam_type_code) {
                $this->examGradeService->gradeExamCatByExamQuestionListAndRoomUkomIdAndParticipantId(
                    $examQuestionList,
                    $room_ukom_id,
                    $userContext->getDetails("participant_id")
                );
            }
        });
    }

    public function answer(AnswerDto $answerDto)
    {
        DB::transaction(function () use ($answerDto) {
            $this->answerService->save($answerDto);
        });
    }

    private function validateAttendance($exam_type_code, $room_ukom_id, $participant_id)
    {
        $examAttendance = $this->examAttendanceService->findByExamTypeCodeAndRoomUkomIdAndParticipantId(
            $exam_type_code,
            $room_ukom_id,
            $participant_id
        );

        if (!$examAttendance) {
            throw new NotFoundException("attendance not found");
        } else if ($examAttendance->finish_at) {
            throw new BusinessException("Exam's already ended", "");
        }
    }
}
