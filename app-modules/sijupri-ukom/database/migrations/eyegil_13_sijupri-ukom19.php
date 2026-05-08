<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
	public function up()
	{

		// Schema::table('ukm_exam_schedule', function (Blueprint $table) {
		// 	if (!Schema::hasColumn('ukm_exam_schedule', 'graded')) {
		// 		$table->boolean('graded')->default(false);
		// 	}
		// });
	}

	public function down()
	{
	}
};
