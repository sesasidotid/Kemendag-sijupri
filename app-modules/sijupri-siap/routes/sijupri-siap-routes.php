<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\SijupriSiap\Http\Controllers\ForgotPasswordController;
use Eyegil\SijupriSiap\Http\Controllers\JFController;
use Eyegil\SijupriSiap\Http\Controllers\JFTaskController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatJabatanController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatJabatanTaskController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatKinerjaController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatKinerjaTaskController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatKompetensiController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatKompetensiTaskController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatPangkatController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatPangkatTaskController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatPendidikanController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatPendidikanTaskController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatSertifikasiController;
use Eyegil\SijupriSiap\Http\Controllers\RiwayatSertifikasiTaskController;
use Eyegil\SijupriSiap\Http\Controllers\UserInstansiController;
use Eyegil\SijupriSiap\Http\Controllers\UserUnitKerjaController;
use Eyegil\SijupriSiap\Http\Controllers\ProfileImageController;

RESTor::createRest(UserInstansiController::class)
    ->createRest(UserUnitKerjaController::class)
    ->createRest(JFTaskController::class)
    ->createRest(JFController::class)
    ->createRest(RiwayatJabatanTaskController::class)
    ->createRest(RiwayatJabatanController::class)
    ->createRest(RiwayatKinerjaTaskController::class)
    ->createRest(RiwayatKinerjaController::class)
    ->createRest(RiwayatKompetensiTaskController::class)
    ->createRest(RiwayatKompetensiController::class)
    ->createRest(RiwayatPangkatTaskController::class)
    ->createRest(RiwayatPangkatController::class)
    ->createRest(RiwayatPendidikanTaskController::class)
    ->createRest(RiwayatPendidikanController::class)
    ->createRest(RiwayatSertifikasiTaskController::class)
    ->createRest(RiwayatSertifikasiController::class)
    ->createRest(ProfileImageController::class)
    ->createRest(ForgotPasswordController::class)
    ->build();
