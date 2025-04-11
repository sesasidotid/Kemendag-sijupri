<?php

namespace Eyegil\SijupriMaintenance\Providers;

use Eyegil\SijupriMaintenance\Services\InstansiService;
use Eyegil\SijupriMaintenance\Services\InstansiTypeService;
use Eyegil\SijupriMaintenance\Services\JabatanService;
use Eyegil\SijupriMaintenance\Services\JenisKelaminService;
use Eyegil\SijupriMaintenance\Services\JenjangService;
use Eyegil\SijupriMaintenance\Services\KabupatenKotaService;
use Eyegil\SijupriMaintenance\Services\KategoriPengembanganService;
use Eyegil\SijupriMaintenance\Services\KategoriSertifikasiService;
use Eyegil\SijupriMaintenance\Services\PangkatService;
use Eyegil\SijupriMaintenance\Services\PendidikanPangkatService;
use Eyegil\SijupriMaintenance\Services\PendidikanService;
use Eyegil\SijupriMaintenance\Services\PredikatKinerjaService;
use Eyegil\SijupriMaintenance\Services\ProvinsiService;
use Eyegil\SijupriMaintenance\Services\RatingKinerjaService;
use Eyegil\SijupriMaintenance\Services\UnitKerjaService;
use Eyegil\SijupriMaintenance\Services\WilayahService;
use Illuminate\Support\ServiceProvider;

class SijupriMaintenanceServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->singleton(InstansiService::class, function ($app) {
			return new InstansiService();
		});

		$this->app->singleton(InstansiTypeService::class, function ($app) {
			return new InstansiTypeService();
		});

		$this->app->singleton(JabatanService::class, function ($app) {
			return new JabatanService();
		});

		$this->app->singleton(JenisKelaminService::class, function ($app) {
			return new JenisKelaminService();
		});

		$this->app->singleton(JenjangService::class, function ($app) {
			return new JenjangService();
		});

		$this->app->singleton(KabupatenKotaService::class, function ($app) {
			return new KabupatenKotaService();
		});

		$this->app->singleton(KategoriPengembanganService::class, function ($app) {
			return new KategoriPengembanganService();
		});

		$this->app->singleton(KategoriSertifikasiService::class, function ($app) {
			return new KategoriSertifikasiService();
		});

		$this->app->singleton(PangkatService::class, function ($app) {
			return new PangkatService();
		});

		$this->app->singleton(PendidikanPangkatService::class, function ($app) {
			return new PendidikanPangkatService();
		});

		$this->app->singleton(PendidikanService::class, function ($app) {
			return new PendidikanService();
		});

		$this->app->singleton(PredikatKinerjaService::class, function ($app) {
			return new PredikatKinerjaService();
		});

		$this->app->singleton(ProvinsiService::class, function ($app) {
			return new ProvinsiService();
		});

		$this->app->singleton(RatingKinerjaService::class, function ($app) {
			return new RatingKinerjaService();
		});

		$this->app->singleton(UnitKerjaService::class, function ($app) {
			return new UnitKerjaService();
		});

		$this->app->singleton(WilayahService::class, function ($app) {
			return new WilayahService();
		});
	}

	public function boot(): void
	{
	}
}
