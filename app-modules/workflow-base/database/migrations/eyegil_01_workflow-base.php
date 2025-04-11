<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\WorkflowBase\Models\Assignee;
use Eyegil\WorkflowBase\Models\Flows;
use Eyegil\WorkflowBase\Models\ObjectKey;
use Eyegil\WorkflowBase\Models\ObjectTask;
use Eyegil\WorkflowBase\Models\PendingTask;
use Eyegil\WorkflowBase\Models\ProcessInstance;
use Eyegil\WorkflowBase\Models\Workflow;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

return new class() extends Migration
{
	public function up()
	{
		Log::info(Workflow::class);
		$migrator = new Migrator();
		$migrator->createSchema(Workflow::class)
			->createSchema(Flows::class)
			->createSchema(ProcessInstance::class)
			->createSchema(ObjectTask::class)
			->createSchema(PendingTask::class)
			->createSchema(ObjectKey::class)
			->createSchema(Assignee::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Workflow::class)
			->createSchema(Flows::class)
			->createSchema(ProcessInstance::class)
			->createSchema(ObjectTask::class)
			->createSchema(PendingTask::class)
			->createSchema(ObjectKey::class)
			->createSchema(Assignee::class)
			->down();
	}
};
