<?php

use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {

        Schema::table('tbl_formasi_dokumen', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_formasi_dokumen', 'delete_flag'))
                $table->boolean('delete_flag')->default(false);
            if (!Schema::hasColumn('tbl_formasi_dokumen', 'inactive_flag'))
                $table->boolean('inactive_flag')->default(false);
            if (!Schema::hasColumn('tbl_formasi_dokumen', 'waktu_pelaksanaan')) {
                $table->timestamp('waktu_pelaksanaan')->nullable();
            }
            if (!Schema::hasColumn('tbl_formasi_dokumen', 'file_surat_undangan')) {
                $table->string('file_surat_undangan')->nullable();
            }
            if (!Schema::hasColumn('tbl_formasi_dokumen', 'task_status')) {
                $table->string('task_status')->default(TaskStatus::PENDING);
            }
        });

        Schema::table('tbl_formasi', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_formasi', 'waktu_pelaksanaan')) {
                $table->timestamp('waktu_pelaksanaan')->nullable();
            }
            if (!Schema::hasColumn('tbl_formasi', 'file_surat_undangan')) {
                $table->string('file_surat_undangan')->nullable();
            }
            if (!Schema::hasColumn('tbl_formasi', 'file_rekomendasi')) {
                $table->string('file_rekomendasi')->nullable();
            }
            if (!Schema::hasColumn('tbl_formasi', 'confirmation_flag')) {
                $table->boolean('confirmation_flag')->default(true);
            }
            if (!Schema::hasColumn('tbl_formasi', 'rekomendasi_flag')) {
                $table->boolean('rekomendasi_flag')->default(false);
            }
            if (!Schema::hasColumn('tbl_formasi', 'formasi_dokumen_id')) {
                $table->unsignedBigInteger('formasi_dokumen_id')->nullable();
                $table->foreign('formasi_dokumen_id')->references('id')->on('tbl_formasi_dokumen');
            }
            if (!Schema::hasColumn('tbl_formasi', 'total_result')) {
                $table->integer('total_result')->nullable();
            }
        });
    }

    public function down()
    {
    }
};
