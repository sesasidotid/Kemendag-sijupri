<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriMaintenance\Models\Counter;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Counter::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Counter::class)
			->down();
	}
};
