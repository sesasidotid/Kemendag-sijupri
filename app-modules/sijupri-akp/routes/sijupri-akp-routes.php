<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\SijupriAkp\Http\Controllers\AkpController;
use Eyegil\SijupriAkp\Http\Controllers\AkpPelatihanTeknisController;
use Eyegil\SijupriAkp\Http\Controllers\AkpTaskController;
use Eyegil\SijupriAkp\Http\Controllers\InstrumentController;
use Eyegil\SijupriAkp\Http\Controllers\KategoriInstrumentController;
use Eyegil\SijupriAkp\Http\Controllers\KompetensiController;
use Eyegil\SijupriAkp\Http\Controllers\MatrixController;
use Eyegil\SijupriAkp\Http\Controllers\PelatihanController;
use Eyegil\SijupriAkp\Http\Controllers\PertanyaanController;

RESTor::createRest(InstrumentController::class)
    ->createRest(KategoriInstrumentController::class)
    // ->createRest(KompetensiController::class)
    ->createRest(MatrixController::class)
    ->createRest(PertanyaanController::class)
    ->createRest(AkpTaskController::class)
    ->createRest(AkpController::class)
    ->createRest(AkpPelatihanTeknisController::class)
    ->build();
