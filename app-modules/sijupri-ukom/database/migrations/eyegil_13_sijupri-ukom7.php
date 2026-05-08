<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriUkom\Models\UkomRegistrationRules;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_registration_rules', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_registration_rules', 'tmt_last_n_year')) {
				$table->integer('tmt_last_n_year')->default(0);
			}
		});
	}

	public function down()
	{
	}
};
