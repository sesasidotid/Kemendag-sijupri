<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_exam_schedule', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_exam_schedule', 'secret_key')) {
				$table->string('secret_key')->nullable(true);
			}
		});
	}

	public function down()
	{
	}
};
