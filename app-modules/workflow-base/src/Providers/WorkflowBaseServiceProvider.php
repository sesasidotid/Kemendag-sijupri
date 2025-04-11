<?php

namespace Eyegil\WorkflowBase\Providers;

use Eyegil\WorkflowBase\Services\EygineService;
use Eyegil\WorkflowBase\Services\ObjectKeyService;
use Eyegil\WorkflowBase\Services\ObjectTaskService;
use Eyegil\WorkflowBase\Services\PendingTaskService;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Eyegil\WorkflowBase\Services\WorkflowValidationService;
use Illuminate\Support\ServiceProvider;

class WorkflowBaseServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(EygineService::class, function ($app) {
			return new EygineService();
		});

		$this->app->singleton(ObjectKeyService::class, function ($app) {
			return new ObjectKeyService();
		});

		$this->app->singleton(PendingTaskService::class, function ($app) {
			return new PendingTaskService();
		});

		$this->app->singleton(WorkflowService::class, function ($app) {
			return new WorkflowService($app->make(PendingTaskService::class), $app->make(ObjectTaskService::class), $app->make(WorkflowValidationService::class), $app->make(ObjectKeyService::class));
		});

		$this->app->singleton(WorkflowValidationService::class, function ($app) {
			return new WorkflowValidationService($app->make(PendingTaskService::class));
		});
	}

	public function boot(): void
	{
	}
}
