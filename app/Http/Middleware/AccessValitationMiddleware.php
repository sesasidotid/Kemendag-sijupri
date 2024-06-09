<?php

namespace App\Http\Middleware;

use App\Enums\RoleCode;
use App\Exceptions\BusinessException;
use Closure;
use Illuminate\Support\Str;

class AccessValitationMiddleware
{
    public function handle($request, Closure $next)
    {
        $userContext = auth()->user();

        if ($userContext->role->base == RoleCode::USER) {
            $route = $request->route();
            $routeName = "/" . ($route ? $route->uri() : "");

            if (Str::startsWith($routeName, "/ukom")) {
                $this->accessUkom($userContext);
            } else if (Str::startsWith($routeName, "/akp")) {
                $this->accessAkp($userContext);
            }
        }

        return $next($request);
    }

    private function accessAkp($userContext)
    {
        $userDetail = $userContext->userDetail ?? null;
        if (!$userDetail) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Data Diri Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userJabatan = $userContext->userJabatan ?? [];
        if (count($userJabatan) == 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Riwayat Jabatan Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userPangkat = $userContext->userPangkat ?? [];
        if (count($userPangkat) == 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Riwayat Pankgat Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        //--------------------------

        $userJabatan = $userContext->userJabatanPending ?? [];
        if (count($userJabatan) > 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Menunggu Konfirmasi Riwayat Jabatan Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userPangkat = $userContext->userPangkatPending ?? [];
        if (count($userPangkat) > 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Menunggu Konfirmasi Riwayat Pankgat Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }
    }

    private function accessUkom($userContext)
    {

        $userDetail = $userContext->userDetail ?? null;
        if (!$userDetail) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Data Diri Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userJabatan = $userContext->userJabatan ?? [];
        if (count($userJabatan) == 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Riwayat Jabatan Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userPangkat = $userContext->userPangkat ?? [];
        if (count($userPangkat) == 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Riwayat Pankgat Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userKompetensi = $userContext->userKompetensi ?? [];
        if (count($userKompetensi) == 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Riwayat Kompetensi Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userPak = $userContext->userPak ?? [];
        if (count($userPak) == 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Riwayat Kinerja Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userPendidikan = $userContext->userPendidikan ?? [];
        if (count($userPendidikan) == 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Riwayat Pendidikan Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userSertifikasi = $userContext->userSertifikasi ?? [];
        if (count($userSertifikasi) == 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Mengisikan Riwayat Sertifikasi Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        //--------------------------


        $userJabatan = $userContext->userJabatanPending ?? [];
        if (count($userJabatan) > 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Menunggu Konfirmasi Riwayat Jabatan Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userPangkat = $userContext->userPangkatPending ?? [];
        if (count($userPangkat) > 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Menunggu Konfirmasi Riwayat Pankgat Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userKompetensi = $userContext->userKompetensiPending ?? [];
        if (count($userKompetensi) > 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Menunggu Konfirmasi Riwayat Kompetensi Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userPak = $userContext->userPakPending ?? [];
        if (count($userPak) > 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Menunggu Konfirmasi Riwayat Kinerja Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userPendidikan = $userContext->userPendidikanPending ?? [];
        if (count($userPendidikan) > 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Menunggu Konfirmasi Riwayat Pendidikan Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }

        $userSertifikasi = $userContext->userSertifikasiPending ?? [];
        if (count($userSertifikasi) > 0) {
            throw new BusinessException([
                "message" => "Mohon Untuk Menunggu Konfirmasi Riwayat Sertifikasi Terlebih Dahulu",
                "error code" => "AVAL-00001",
                "code" => 500
            ], 500);
        }
    }
}
