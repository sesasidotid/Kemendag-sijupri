<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('tbl_system_configuration'))
            Schema::create('tbl_system_configuration', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->string('name');
                $table->string('type'); // replace, dynamic
                $table->json('property');
                $table->string('validation');
                $table->string('validation_type')->nullable();
            });

        if (!Schema::hasTable('tbl_storage'))
            Schema::create('tbl_storage', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('association');
                $table->string('association_key');
                $table->string('file');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_jabatan'))
            Schema::create('tbl_jabatan', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('type');
                $table->string('bidang');
                $table->integer('urutan');
                $table->string('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });


        if (!Schema::hasTable('tbl_jenjang'))
            Schema::create('tbl_jenjang', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->integer('urutan');
                $table->string('name');
                $table->string('type');
                $table->float('puncak_jenjang')->nullable();
                $table->string('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_pangkat'))
            Schema::create('tbl_pangkat', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_pendidikan'))
            Schema::create('tbl_pendidikan', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_provinsi'))
            Schema::create('tbl_provinsi', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->double('latitude')->nullable();
                $table->double('longitude')->nullable();
            });

        if (!Schema::hasTable('tbl_tipe_instansi'))
            Schema::create('tbl_tipe_instansi', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_wilayah'))
            Schema::create('tbl_wilayah', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('region');
                $table->float('pengali');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_kab_kota'))
            Schema::create('tbl_kab_kota', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('type');
                $table->string('name');
                $table->string('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->double('latitude')->nullable();
                $table->double('longitude')->nullable();

                $table->unsignedBigInteger('provinsi_id');

                $table->foreign('provinsi_id')->references('id')->on('tbl_provinsi');
            });

        if (!Schema::hasTable('tbl_instansi'))
            Schema::create('tbl_instansi', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description');
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('tipe_instansi_code');
                $table->unsignedBigInteger('provinsi_id')->nullable();
                $table->unsignedBigInteger('kabupaten_id')->nullable();
                $table->unsignedBigInteger('kota_id')->nullable();

                $table->foreign('provinsi_id')->references('id')->on('tbl_provinsi');
                $table->foreign('kabupaten_id')->references('id')->on('tbl_kab_kota');
                $table->foreign('kota_id')->references('id')->on('tbl_kab_kota');
                $table->foreign('tipe_instansi_code')->references('code')->on('tbl_tipe_instansi');
            });

        if (!Schema::hasTable('tbl_unit_kerja'))
            Schema::create('tbl_unit_kerja', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->enum('operasional', ['DINAS', 'KEMENTERIAN'])->default('DINAS');
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('alamat')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('tipe_instansi_code');
                $table->string('wilayah_code')->nullable();
                $table->string('file_rekomendasi_formasi')->nullable();
                $table->double('latitude')->nullable();
                $table->double('longitude')->nullable();
                $table->unsignedBigInteger('instansi_id')->nullable();

                $table->foreign('instansi_id')->references('id')->on('tbl_instansi');
                $table->foreign('tipe_instansi_code')->references('code')->on('tbl_tipe_instansi');
                $table->foreign('wilayah_code')->references('code')->on('tbl_wilayah');
            });

        if (!Schema::hasTable('tbl_dokumen_persyaratan'))
            Schema::create('tbl_dokumen_persyaratan', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('code');
                $table->string('name');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_jenjang_pangkat'))
            Schema::create('tbl_jenjang_pangkat', function (Blueprint $table) {
                $table->id();
                $table->string('jenjang');
                $table->float('puncak_jenjang')->nullable();
            });

        if (!Schema::hasTable('tbl_pangkat_golongan'))
            Schema::create('tbl_pangkat_golongan', function (Blueprint $table) {
                $table->id();
                $table->string('pangkat');
            });

        if (!Schema::hasTable('tbl_modul'))
            Schema::create('tbl_modul', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('description')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_pengumuman'))
            Schema::create('tbl_pengumuman', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string("judul")->nullable();
                $table->text("isi")->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
            });

        if (!Schema::hasTable('tbl_tipe_jabatan'))
            Schema::create('tbl_tipe_jabatan', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_jabatan_jenjang_pangkat'))
            Schema::create('tbl_jabatan_jenjang_pangkat', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('angka_kredit');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('jabatan_code');
                $table->unsignedBigInteger('jenjang_pangkat_id');

                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
                $table->foreign('jenjang_pangkat_id')->references('id')->on('tbl_jenjang_pangkat');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_system_configuration');
        Schema::dropIfExists('tbl_storage');
        Schema::dropIfExists('tbl_jabatan');
        Schema::dropIfExists('tbl_jenjang');
        Schema::dropIfExists('tbl_pangkat');
        Schema::dropIfExists('tbl_pendidikan');
        Schema::dropIfExists('tbl_provinsi');
        Schema::dropIfExists('tbl_tipe_instansi');
        Schema::dropIfExists('tbl_wilayah');
        Schema::dropIfExists('tbl_instansi');

        Schema::dropIfExists('tbl_kab_kota');
        Schema::dropIfExists('tbl_unit_kerja');

        Schema::dropIfExists('tbl_dokumen_persyaratan');
        Schema::dropIfExists('tbl_modul');
        Schema::dropIfExists('tbl_pangkat_golongan');
        Schema::dropIfExists('tbl_jenjang_pangkat');
        Schema::dropIfExists('tbl_pengumuman');
        Schema::dropIfExists('tbl_tipe_jabatan');
        Schema::dropIfExists('tbl_jabatan_jenjang_pangkat');
    }
};
