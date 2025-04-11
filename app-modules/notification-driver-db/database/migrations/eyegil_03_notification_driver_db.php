<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\NotificationDriverDb\Models\NotificationMessage;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
	public function up()
	{
		(new Migrator())->createSchema(NotificationMessage::class)
			->up();
	}

	public function down()
	{
		(new Migrator())->createSchema(NotificationMessage::class)
			->down();
	}
};
