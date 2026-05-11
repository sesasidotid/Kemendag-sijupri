<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_grade', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_grade', 'makalah_grade_id')) {
				$table->string('makalah_grade_id')->references('id')->on('ukm_exam_grade')->onDelete('cascade');
			}
		});
	}

	public function down()
	{
	}
};
