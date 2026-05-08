<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
	public function up()
	{

		Schema::table('ukm_participant_schedule', callback: function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_participant_schedule', 'examined')) {
				$table->boolean('examined')->nullable()->default(false);
			}
		});
	}

	public function down()
	{
	}
};
