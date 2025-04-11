<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SecurityPassword\Models\Password;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration
{
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Password::class)->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Password::class)->down();
	}
};
