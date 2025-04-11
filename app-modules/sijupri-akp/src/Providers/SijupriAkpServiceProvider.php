<?php

namespace Eyegil\SijupriAkp\Providers;

use App\Services\SendNotifyService;
use Eyegil\NotificationBase\Services\NotificationService;
use Eyegil\SijupriAkp\Services\AkpPelatihanTeknisService;
use Eyegil\SijupriAkp\Services\AkpRekapService;
use Eyegil\SijupriAkp\Services\AkpService;
use Eyegil\SijupriAkp\Services\AkpTaskService;
use Eyegil\SijupriAkp\Services\InstrumentService;
use Eyegil\SijupriAkp\Services\KategoriInstrumentService;
use Eyegil\SijupriAkp\Services\Matrix1Service;
use Eyegil\SijupriAkp\Services\Matrix2Service;
use Eyegil\SijupriAkp\Services\Matrix3Service;
use Eyegil\SijupriAkp\Services\MatrixService;
use Eyegil\SijupriAkp\Services\PertanyaanService;
use Eyegil\SijupriMaintenance\Services\JabatanJenjangService;
use Eyegil\SijupriSiap\Services\JFService;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\ServiceProvider;

class SijupriAkpServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(InstrumentService::class, function ($app) {
			return new InstrumentService();
		});

		$this->app->singleton(AkpService::class, function ($app) {
			return new AkpService(
				$app->make(KategoriInstrumentService::class),
				$app->make(PertanyaanService::class),
				$app->make(MatrixService::class),
				$app->make(WorkflowService::class),
				$app->make(SendNotifyService::class)
			);
		});

		$this->app->singleton(AkpTaskService::class, function ($app) {
			return new AkpTaskService(
				$app->make(AkpService::class),
				$app->make(WorkflowService::class),
				$app->make(JFService::class),
				$app->make(JabatanJenjangService::class),
				$app->make(InstrumentService::class),
				$app->make(StorageService::class),
				$app->make(SendNotifyService::class)
			);
		});

		$this->app->singleton(AkpPelatihanTeknisService::class, function ($app) {
			return new AkpPelatihanTeknisService(
				$app->make(InstrumentService::class),
				$app->make(KategoriInstrumentService::class)
			);
		});

		$this->app->singleton(MatrixService::class, function ($app) {
			return new MatrixService(
				$app->make(Matrix1Service::class),
				$app->make(Matrix2Service::class),
				$app->make(Matrix3Service::class),
				$app->make(AkpRekapService::class),
			);
		});

		$this->app->singleton(Matrix1Service::class, function ($app) {
			return new Matrix1Service();
		});

		$this->app->singleton(Matrix2Service::class, function ($app) {
			return new Matrix2Service();
		});

		$this->app->singleton(Matrix3Service::class, function ($app) {
			return new Matrix3Service();
		});

		$this->app->singleton(AkpRekapService::class, function ($app) {
			return new AkpRekapService(
				$app->make(StorageService::class),
				$app->make(StorageSystemService::class)
			);
		});

		$this->app->singleton(PertanyaanService::class, function ($app) {
			return new PertanyaanService();
		});

		$this->app->singleton(KategoriInstrumentService::class, function ($app) {
			return new KategoriInstrumentService(
				$app->make(PertanyaanService::class)
			);
		});
	}

	public function boot(): void {}
}
