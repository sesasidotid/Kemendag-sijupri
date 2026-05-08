<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{

		Schema::table('ukm_participant_schedule', callback: function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_participant_schedule', 'personal_schedule')) {
				$table->dateTime('personal_schedule')->nullable();
			}
		});
	}

	public function down()
	{
	}
};
