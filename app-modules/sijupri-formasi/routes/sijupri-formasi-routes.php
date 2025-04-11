<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\SijupriFormasi\Http\Controllers\FormasiController;
use Eyegil\SijupriFormasi\Http\Controllers\FormasiDetailController;
use Eyegil\SijupriFormasi\Http\Controllers\FormasiDokumenController;
use Eyegil\SijupriFormasi\Http\Controllers\FormasiProsesVerifikasiController;
use Eyegil\SijupriFormasi\Http\Controllers\FormasiTaskController;
use Eyegil\SijupriFormasi\Http\Controllers\PendingFormasiController;
use Eyegil\SijupriFormasi\Http\Controllers\UnsurController;

RESTor::createRest(FormasiTaskController::class)
    ->createRest(FormasiController::class)
    ->createRest(UnsurController::class)
    ->createRest(PendingFormasiController::class)
    ->createRest(FormasiDokumenController::class)
    ->createRest(FormasiDetailController::class)
    ->createRest(FormasiProsesVerifikasiController::class)
    ->build();
