<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\SijupriMaintenance\Controllers\KompetensiController;
use Eyegil\SijupriMaintenance\Controllers\BidangJabatanController;
use Eyegil\SijupriMaintenance\Controllers\DokumenPersyaratanController;
use Eyegil\SijupriMaintenance\Controllers\InstansiController;
use Eyegil\SijupriMaintenance\Controllers\InstansiTypeController;
use Eyegil\SijupriMaintenance\Controllers\JabatanController;
use Eyegil\SijupriMaintenance\Controllers\JenisKelaminController;
use Eyegil\SijupriMaintenance\Controllers\JenjangController;
use Eyegil\SijupriMaintenance\Controllers\KabupatenKotaController;
use Eyegil\SijupriMaintenance\Controllers\KategoriPengembanganController;
use Eyegil\SijupriMaintenance\Controllers\KategoriSertifikasiController;
use Eyegil\SijupriMaintenance\Controllers\PangkatController;
use Eyegil\SijupriMaintenance\Controllers\PendidikanController;
use Eyegil\SijupriMaintenance\Controllers\PeriodePendaftaranController;
use Eyegil\SijupriMaintenance\Controllers\PredikatKinerjaController;
use Eyegil\SijupriMaintenance\Controllers\ProvinsiController;
use Eyegil\SijupriMaintenance\Controllers\RatingKinerjaController;
use Eyegil\SijupriMaintenance\Controllers\SystemConfigurationController;
use Eyegil\SijupriMaintenance\Controllers\UnitKerjaController;
use Eyegil\SijupriMaintenance\Controllers\WilayahController;

RESTor::createRest(InstansiController::class)
    ->createRest(InstansiTypeController::class)
    ->createRest(JabatanController::class)
    ->createRest(JenisKelaminController::class)
    ->createRest(JenjangController::class)
    ->createRest(KabupatenKotaController::class)
    ->createRest(KategoriPengembanganController::class)
    ->createRest(KategoriSertifikasiController::class)
    ->createRest(PangkatController::class)
    ->createRest(PendidikanController::class)
    ->createRest(PeriodePendaftaranController::class)
    ->createRest(PredikatKinerjaController::class)
    ->createRest(ProvinsiController::class)
    ->createRest(RatingKinerjaController::class)
    ->createRest(UnitKerjaController::class)
    ->createRest(WilayahController::class)
    ->createRest(DokumenPersyaratanController::class)
    ->createRest(BidangJabatanController::class)
    ->createRest(KompetensiController::class)
    ->createRest(SystemConfigurationController::class)
    ->build();
