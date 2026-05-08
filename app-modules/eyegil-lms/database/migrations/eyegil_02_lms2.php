<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('lms_answer', function (Blueprint $table) {
			if (!Schema::hasColumn('lms_answer', 'is_uncertain')) {
				$table->boolean('is_uncertain')->default(false);
			}
		});
	}

	public function down()
	{
	}
};
