<?php

namespace Eyegil\SijupriSiap\Providers;

use App\Services\SendNotifyService;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SecurityBase\Services\UserService;
use Eyegil\SijupriSiap\Services\JFService;
use Eyegil\SijupriSiap\Services\JFTaskService;
use Eyegil\SijupriSiap\Services\RiwayatJabatanService;
use Eyegil\SijupriSiap\Services\RiwayatJabatanTaskService;
use Eyegil\SijupriSiap\Services\RiwayatKinerjaService;
use Eyegil\SijupriSiap\Services\RiwayatKinerjaTaskService;
use Eyegil\SijupriSiap\Services\RiwayatKompetensiService;
use Eyegil\SijupriSiap\Services\RiwayatKompetensiTaskService;
use Eyegil\SijupriSiap\Services\RiwayatPangkatService;
use Eyegil\SijupriSiap\Services\RiwayatPangkatTaskService;
use Eyegil\SijupriSiap\Services\RiwayatPendidikanService;
use Eyegil\SijupriSiap\Services\RiwayatPendidikanTaskService;
use Eyegil\SijupriSiap\Services\RiwayatSertifikasiService;
use Eyegil\SijupriSiap\Services\RiwayatSertifikasiTaskService;
use Eyegil\SijupriSiap\Services\UserInstansiService;
use Eyegil\SijupriSiap\Services\UserUnitKerjaService;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\ServiceProvider;

class SijupriSiapServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(JFService::class, function ($app) {
			return new JFService(
				$app->make(UserAuthenticationService::class),
				$app->make(UserService::class),
			);
		});

		$this->app->singleton(JFTaskService::class, function ($app) {
			return new JFTaskService($app->make(JFService::class), $app->make(StorageService::class), $app->make(WorkflowService::class));
		});

		$this->app->singleton(RiwayatJabatanService::class, function ($app) {
			return new RiwayatJabatanService($app->make(StorageService::class));
		});

		$this->app->singleton(RiwayatKinerjaService::class, function ($app) {
			return new RiwayatKinerjaService($app->make(StorageService::class));
		});

		$this->app->singleton(RiwayatKompetensiService::class, function ($app) {
			return new RiwayatKompetensiService($app->make(StorageService::class));
		});

		$this->app->singleton(RiwayatPangkatService::class, function ($app) {
			return new RiwayatPangkatService($app->make(StorageService::class));
		});

		$this->app->singleton(RiwayatPendidikanService::class, function ($app) {
			return new RiwayatPendidikanService($app->make(StorageService::class));
		});

		$this->app->singleton(RiwayatSertifikasiService::class, function ($app) {
			return new RiwayatSertifikasiService($app->make(StorageService::class));
		});

		$this->app->singleton(UserInstansiService::class, function ($app) {
			return new UserInstansiService(
				$app->make(UserAuthenticationService::class),
				$app->make(UserService::class),
			);
		});

		$this->app->singleton(UserUnitKerjaService::class, function ($app) {
			return new UserUnitKerjaService(
				$app->make(UserAuthenticationService::class),
				$app->make(UserService::class),
			);
		});

		$this->app->singleton(RiwayatPendidikanTaskService::class, function ($app) {
			return new RiwayatPendidikanTaskService(
				$app->make(RiwayatPendidikanService::class),
				$app->make(StorageService::class),
				$app->make(WorkflowService::class),
				$app->make(SendNotifyService::class)
			);
		});

		$this->app->singleton(RiwayatPangkatTaskService::class, function ($app) {
			return new RiwayatPangkatTaskService(
				$app->make(RiwayatPangkatService::class),
				$app->make(StorageService::class),
				$app->make(WorkflowService::class),
				$app->make(SendNotifyService::class),
			);
		});

		$this->app->singleton(RiwayatJabatanTaskService::class, function ($app) {
			return new RiwayatJabatanTaskService(
				$app->make(RiwayatJabatanService::class),
				$app->make(StorageService::class),
				$app->make(WorkflowService::class),
				$app->make(SendNotifyService::class)
			);
		});

		$this->app->singleton(RiwayatKinerjaTaskService::class, function ($app) {
			return new RiwayatKinerjaTaskService(
				$app->make(RiwayatKinerjaService::class),
				$app->make(StorageService::class),
				$app->make(WorkflowService::class),
				$app->make(SendNotifyService::class)
			);
		});

		$this->app->singleton(RiwayatKompetensiTaskService::class, function ($app) {
			return new RiwayatKompetensiTaskService(
				$app->make(RiwayatKompetensiService::class),
				$app->make(StorageService::class),
				$app->make(WorkflowService::class),
				$app->make(SendNotifyService::class)
			);
		});

		$this->app->singleton(RiwayatSertifikasiTaskService::class, function ($app) {
			return new RiwayatSertifikasiTaskService(
				$app->make(RiwayatSertifikasiService::class),
				$app->make(StorageService::class),
				$app->make(WorkflowService::class),
				$app->make(SendNotifyService::class)
			);
		});
	}

	public function boot(): void {}
}
