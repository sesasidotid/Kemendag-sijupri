<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SecurityBase\Models\Device;
use Eyegil\SecurityBase\Models\Application;
use Eyegil\SecurityBase\Models\ApplicationChannel;
use Eyegil\SecurityBase\Models\Channel;
use Eyegil\SecurityBase\Models\Menu;
use Eyegil\SecurityBase\Models\Role;
use Eyegil\SecurityBase\Models\RoleMenu;
use Eyegil\SecurityBase\Models\User;
use Eyegil\SecurityBase\Models\UserApplicationChannel;
use Eyegil\SecurityBase\Models\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

return new class() extends Migration
{
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Application::class)
			->createSchema(Channel::class)
			->createSchema(User::class)
			->createSchema(Role::class)
			->createSchema(Menu::class)
			->createSchema(UserRole::class)
			->createSchema(RoleMenu::class)
			->createSchema(ApplicationChannel::class)
			->createSchema(UserApplicationChannel::class)
			->createSchema(Device::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Application::class)
			->createSchema(Channel::class)
			->createSchema(User::class)
			->createSchema(Role::class)
			->createSchema(Menu::class)
			->createSchema(UserRole::class)
			->createSchema(RoleMenu::class)
			->createSchema(ApplicationChannel::class)
			->createSchema(UserApplicationChannel::class)
			->createSchema(Device::class)
			->down();
	}
};
