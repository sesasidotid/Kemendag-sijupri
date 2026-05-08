<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriUkom\Models\ExamConfiguration;
use Eyegil\SijupriUkom\Models\ExamSuffleConfiguration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(ExamConfiguration::class)
			->createSchema(ExamSuffleConfiguration::class)
			->up();

		Schema::table('ukm_exam_question', callback: function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_exam_question', 'exam_schedule_id')) {
				$table->string('exam_schedule_id')->nullable()->references('id')->on('ukm_exam_schedule')->onDelete('cascade');
			}
			if (!Schema::hasColumn('ukm_exam_question', 'participant_ukom_id')) {
				$table->string('participant_ukom_id')->nullable()->references('id')->on('ukm_participant')->onDelete('cascade');
			}
			if (!Schema::hasColumn('ukm_exam_question', 'answer_id')) {
				$table->string('answer_id')->nullable()->references('id')->on('lms_answer')->onDelete('cascade');
			}
			if (Schema::hasColumn('ukm_exam_question', 'room_ukom_id')) {
				$table->string('room_ukom_id')->nullable(true)->change();
			}
			if (Schema::hasColumn('ukm_exam_question', 'exam_type_code')) {
				$table->string('exam_type_code')->nullable(true)->change();
			}
		});
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(ExamConfiguration::class)
			->createSchema(ExamSuffleConfiguration::class)
			->down();
	}
};
