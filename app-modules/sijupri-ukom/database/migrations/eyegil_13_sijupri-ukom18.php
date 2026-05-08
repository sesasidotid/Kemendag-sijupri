<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
	public function up()
	{

		Schema::table('ukm_exam_schedule', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_exam_schedule', 'exam_schedule_parent_id')) {
				$table->string('exam_schedule_parent_id')->nullable(true)->default(null);
			}
		});
	}

	public function down()
	{
	}
};
