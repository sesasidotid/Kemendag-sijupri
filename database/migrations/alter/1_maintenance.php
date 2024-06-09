<?php

use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('tbl_system_configuration', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_system_configuration', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('tbl_system_configuration', 'validation')) {
                $table->string('validation')->nullable();
            }
            if (!Schema::hasColumn('tbl_system_configuration', 'validation_type')) {
                $table->string('validation_type')->nullable();
            }
        });

        Schema::table('tbl_storage', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_storage', 'name')) {
                $table->string('name')->nullable();
            }
        });

        Schema::table('tbl_provinsi', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_provinsi', 'longitude')) {
                $table->double('longitude')->nullable();
            }
            if (!Schema::hasColumn('tbl_provinsi', 'latitude')) {
                $table->double('latitude')->nullable();
            }
        });

        Schema::table('tbl_kab_kota', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_kab_kota', 'longitude')) {
                $table->double('longitude')->nullable();
            }
            if (!Schema::hasColumn('tbl_kab_kota', 'latitude')) {
                $table->double('latitude')->nullable();
            }
        });

        Schema::table('tbl_instansi', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_instansi', 'provinsi_id')) {
                $table->unsignedBigInteger('provinsi_id')->nullable();
                $table->foreign('provinsi_id')->references('id')->on('tbl_provinsi');
            }
            if (!Schema::hasColumn('tbl_instansi', 'kabupaten_id')) {
                $table->unsignedBigInteger('kabupaten_id')->nullable();
                $table->foreign('kabupaten_id')->references('id')->on('tbl_kab_kota');
            }
            if (!Schema::hasColumn('tbl_instansi', 'kota_id')) {
                $table->unsignedBigInteger('kota_id')->nullable();
                $table->foreign('kota_id')->references('id')->on('tbl_kab_kota');
            }
        });

        Schema::table('tbl_unit_kerja', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_unit_kerja', 'file_rekomendasi_formasi')) {
                $table->string('file_rekomendasi_formasi')->nullable();
            }
            if (!Schema::hasColumn('tbl_unit_kerja', 'longitude')) {
                $table->double('longitude')->nullable();
            }
            if (!Schema::hasColumn('tbl_unit_kerja', 'latitude')) {
                $table->double('latitude')->nullable();
            }
            if (!Schema::hasColumn('tbl_unit_kerja', 'instansi_id')) {
                $table->unsignedBigInteger('instansi_id')->nullable();
                $table->foreign('instansi_id')->references('id')->on('tbl_instansi');
            }
        });
    }

    public function down()
    {
    }
};
