<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\NotificationFirebase\Models\FirebaseMessageToken;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
	
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(FirebaseMessageToken::class)
			->up();
	}
	
	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(FirebaseMessageToken::class)
			->down();
	}
};
