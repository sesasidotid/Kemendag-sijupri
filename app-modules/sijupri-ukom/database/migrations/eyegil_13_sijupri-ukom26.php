<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_exam_schedule', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_exam_schedule', 'examiner_amount')) {
				$table->integer('examiner_amount')->default(1);
			}
		});
	}

	public function down()
	{
	}
};
