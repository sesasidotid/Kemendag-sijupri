<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_formasi_periode'))
            Schema::create('tbl_formasi_periode', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->date("periode")->nullable();
                $table->string("file_surat_undangan")->nullable();
                $table->string("task_status")->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(true);
            });

        if (!Schema::hasTable('tbl_formasi_dokumen'))
            Schema::create('tbl_formasi_dokumen', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->timestamp('waktu_pelaksanaan')->nullable();
                $table->string('file_surat_undangan')->nullable();
                $table->unsignedBigInteger('unit_kerja_id');

                $table->foreign('unit_kerja_id')->references('id')->on('tbl_unit_kerja');
            });

        if (!Schema::hasTable('tbl_formasi_score'))
            Schema::create('tbl_formasi_score', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->unsignedBigInteger('main_id')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->text('unsur');
                $table->float('volume')->nullable();
                $table->float('score')->nullable();
                $table->string('lvl')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->unsignedBigInteger('formasi_id')->nullable();
                $table->string('jenjang_code')->nullable();
                $table->unsignedBigInteger('formasi_unsur_id')->nullable();

                $table->foreign('formasi_id')->references('id')->on('tbl_formasi');
                $table->foreign('jenjang_code')->references('code')->on('tbl_jenjang');
                $table->foreign('formasi_unsur_id')->references('id')->on('tbl_formasi_unsur');
            });


        if (!Schema::hasTable('tbl_formasi'))
            Schema::create('tbl_formasi', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->integer('total')->nullable();
                $table->integer('total_result')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->boolean('confirmation_flag')->default(true);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('jabatan_code');
                $table->unsignedBigInteger('unit_kerja_id');
                $table->string('file_rekomendasi')->nullable();
                $table->timestamp('waktu_pelaksanaan')->nullable();
                $table->string('file_surat_undangan')->nullable();
                $table->boolean('rekomendasi_flag')->default(false);
                $table->unsignedBigInteger('formasi_dokumen_id')->nullable();

                $table->foreign('formasi_dokumen_id')->references('id')->on('tbl_formasi_dokumen');
                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
                $table->foreign('unit_kerja_id')->references('id')->on('tbl_unit_kerja');
            });

        if (!Schema::hasTable('tbl_formasi_result'))
            Schema::create('tbl_formasi_result', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->decimal('total', 10, 2);
                $table->decimal('sdm', 10, 2);
                $table->integer('pembulatan');
                $table->integer('result')->nullable();
                $table->string('jenjang_code');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->unsignedBigInteger('formasi_id');

                $table->foreign('jenjang_code')->references('code')->on('tbl_jenjang');
                $table->foreign('formasi_id')->references('id')->on('tbl_formasi');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_formasi_dokumen');
        Schema::dropIfExists('tbl_formasi_result');
        Schema::dropIfExists('tbl_formasi_score');
        Schema::dropIfExists('tbl_formasi');
    }
};
