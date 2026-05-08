<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriUkom\Enums\ExamStatus;
use Eyegil\SijupriUkom\Models\UkomRegistrationRules;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_exam_grade', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_exam_grade', 'inactive_flag')) {
				$table->boolean('inactive_flag')->default(false);
			}
			if (!Schema::hasColumn('ukm_exam_grade', 'delete_flag')) {
				$table->boolean('delete_flag')->default(false);
			}
		});

		Schema::table('ukm_exam_attendance', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_exam_attendance', 'exam_schedule_id')) {
				$table->string('exam_schedule_id')->nullable()->references('id')->on('ukm_exam_schedule')->onDelete('cascade');
			}
			if (Schema::hasColumn('ukm_exam_attendance', 'room_ukom_id')) {
				$table->string('room_ukom_id')->nullable(true)->change();
			}
			if (Schema::hasColumn('ukm_exam_attendance', 'exam_type_code')) {
				$table->string('exam_type_code')->nullable(true)->change();
			}
		});
	}

	public function down()
	{
	}
};
