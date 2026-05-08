<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriUkom\Models\ExaminerUkomType;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(ExaminerUkomType::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(ExaminerUkomType::class)
			->up();
	}
};
