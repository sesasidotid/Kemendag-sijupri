<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriUkom\Models\UkomRegistrationRules;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(UkomRegistrationRules::class)
			->up();

		Schema::table('ukm_participant', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_participant', 'tmt_pangkat')) {
				$table->date('tmt_pangkat')->nullable(true)->default(null);
			}
			if (!Schema::hasColumn('ukm_participant', 'tmt_jabatan')) {
				$table->date('tmt_jabatan')->nullable(true)->default(null);
			}
			if (!Schema::hasColumn('ukm_participant', 'tempat_lahir')) {
				$table->string('tempat_lahir')->nullable(true)->default(null);
			}
		});
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(UkomRegistrationRules::class)
			->down();
	}
};
