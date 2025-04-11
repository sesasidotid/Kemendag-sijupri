<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriUkom\Models\DocumentUkom;
use Eyegil\SijupriUkom\Models\ExaminerUkom;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Eyegil\SijupriUkom\Models\ExamType;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\SijupriUkom\Models\RoomUkom;
use Eyegil\SijupriUkom\Models\UkomBan;
use Eyegil\SijupriUkom\Models\ExamAttendance;
use Eyegil\SijupriUkom\Models\ExamGrade;
use Eyegil\SijupriUkom\Models\ExamGradeMansoskul;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Eyegil\SijupriUkom\Models\UkomFormula;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(ExaminerUkom::class)
			->createSchema(RoomUkom::class)
			->createSchema(ParticipantUkom::class)
			->createSchema(ParticipantRoomUkom::class)
			->createSchema(UkomBan::class)
			->createSchema(ExamType::class)
			->createSchema(ExamSchedule::class)
			->createSchema(DocumentUkom::class)
			->createSchema(ExamQuestion::class)
			->createSchema(ExamAttendance::class)
			->createSchema(ExamGrade::class)
			->createSchema(ExamGradeMansoskul::class)
			->createSchema(UkomGrade::class)
			->createSchema(UkomFormula::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(ExaminerUkom::class)
			->createSchema(RoomUkom::class)
			->createSchema(ParticipantUkom::class)
			->createSchema(ParticipantRoomUkom::class)
			->createSchema(UkomBan::class)
			->createSchema(ExamType::class)
			->createSchema(ExamSchedule::class)
			->createSchema(DocumentUkom::class)
			->createSchema(ExamQuestion::class)
			->createSchema(ExamAttendance::class)
			->createSchema(ExamGrade::class)
			->createSchema(ExamGradeMansoskul::class)
			->createSchema(UkomGrade::class)
			->createSchema(UkomFormula::class)
			->up();
	}
};
