<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\NotificationBase\Models\Notification;
use Eyegil\NotificationBase\Models\NotificationSubscription;
use Eyegil\NotificationBase\Models\NotificationTemplate;
use Eyegil\NotificationBase\Models\NotificationTopic;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Notification::class)
			->createSchema(NotificationTemplate::class)
			->createSchema(NotificationTopic::class)
			->createSchema(NotificationSubscription::class)
			->up();
	}
	
	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Notification::class)
			->createSchema(NotificationTemplate::class)
			->createSchema(NotificationTopic::class)
			->createSchema(NotificationSubscription::class)
			->down();
	}
};
