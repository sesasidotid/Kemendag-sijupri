<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\EyegilLms\Models\Checklist;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Checklist::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Checklist::class)
			->down();
	}
};
