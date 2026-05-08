<?php

use Eyegil\SijupriUkom\Enums\ExamStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_exam_attendance', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_exam_attendance', 'violation_count')) {
				$table->integer('violation_count')->nullable()->default(0);
			}
			if (!Schema::hasColumn('ukm_exam_attendance', 'status')) {
				$table->enum('status', [ExamStatus::ONGOING->name, ExamStatus::FINISHED->name, ExamStatus::DISQUALIFIED->name])->nullable();
			}
		});
	}

	public function down()
	{
	}
};
