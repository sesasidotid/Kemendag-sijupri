<?php

namespace Eyegil\SijupriUkom\Converters;

use Eyegil\SijupriUkom\Dtos\UkomGradeDto;
use Eyegil\SijupriUkom\Models\UkomGrade;

class UkomGradeConverter
{
    public static function toDto(UkomGrade $ukomGrade): UkomGradeDto
    {
        $ukomGradeDto = new UkomGradeDto();
        $ukomGradeDto->fromModel($ukomGrade);

        $catGrade = $ukomGrade->catGrade;
        if ($catGrade) {
            $ukomGradeDto->cat_grade_score = $catGrade->score;
        }
        $wawancaraGrade = $ukomGrade->wawancaraGrade;
        if ($wawancaraGrade) {
            $ukomGradeDto->wawancara_grade_score = $wawancaraGrade->score;
        }
        $seminarGrade = $ukomGrade->seminarGrade;
        if ($seminarGrade) {
            $ukomGradeDto->seminar_grade_score = $seminarGrade->score;
        }
        $praktikGrade = $ukomGrade->praktikGrade;
        if ($praktikGrade) {
            $ukomGradeDto->praktik_grade_score = $praktikGrade->score;
        }
        $portofolioGrade = $ukomGrade->portofolioGrade;
        if ($portofolioGrade) {
            $ukomGradeDto->portofolio_grade_score = $portofolioGrade->score;
        }


        $participantUkom = $ukomGrade->participantUkom;
        if ($participantUkom) {
            $ukomGradeDto->participant_name = $participantUkom->name;
            $ukomGradeDto->nip = $participantUkom->nip;
        }
        $roomUkom = $ukomGrade->roomUkom;
        if ($roomUkom) {
            $ukomGradeDto->room_ukom_name = $roomUkom->name;
        }

        return $ukomGradeDto;
    }
}
