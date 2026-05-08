<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriUkom\Models\ExamScheduleSupervised;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(ExamScheduleSupervised::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(ExamScheduleSupervised::class)
			->down();
	}
};
