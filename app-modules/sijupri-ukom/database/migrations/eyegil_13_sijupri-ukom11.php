<?php

use Eyegil\SijupriUkom\Enums\ExamStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_exam_attendance', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_exam_attendance', 'mouse_away_count')) {
				$table->integer('mouse_away_count')->nullable()->default(0);
			}
		});
	}

	public function down()
	{
	}
};
