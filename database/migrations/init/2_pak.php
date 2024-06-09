<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // if (!Schema::hasTable('tbl_koefisien_poin_performance'))
        //     Schema::create('tbl_koefisien_poin_performance', function (Blueprint $table) {
        //         $table->id();
        //         $table->unsignedBigInteger("jenjang_id");
        //         $table->unsignedBigInteger("pangkat_id");
        //         $table->string('kategori');
        //         $table->integer('max_standar_point')->nullable();

        //         $table->foreign('jenjang_id')->references('id')->on('tbl_jenjang_pangkat');
        //         $table->foreign('pangkat_id')->references('id')->on('tbl_pangkat_golongan');
        //     });


        // if (!Schema::hasTable('tbl_poin_angka_kredit'))
        //     Schema::create('tbl_poin_angka_kredit', function (Blueprint $table) {
        //         $table->id();
        //         $table->unsignedBigInteger('user_id');
        //         $table->integer('test_passed')->nullable();
        //         $table->string("jabatan_code")->nullable();
        //         $table->unsignedBigInteger("jenjang_id")->nullable();
        //         $table->unsignedBigInteger("pangkat_id")->nullable();
        //         $table->unsignedBigInteger("pangkat_id_rekom")->nullable();
        //         $table->unsignedBigInteger("pangkat_id_terakhir")->nullable();
        //         //addition
        //         $table->float('ak_total')->nullable();
        //         $table->float('ak_terbaru')->nullable();
        //         $table->float('ak_terakhir')->nullable();
        //         $table->integer('rating')->nullable();
        //         $table->string('pdf_dokumen_ak_terakhir')->nullable();
        //         $table->string('pdf_hsl_evaluasi_kinerja')->nullable();
        //         $table->string('pdf_akumulasi_ak_konversi')->nullable();
        //         $table->enum('approved', ['0', '1'])->nullable();
        //         //pdf_dokumen_ak_terakhir

        //         //selisih
        //         $table->integer('max_standar_point')->nullable();
        //         $table->integer('max_jenjang')->nullable();
        //         $table->integer('max_pangkat')->nullable();
        //         $table->integer('max_pangkat_terakhir')->nullable();;
        //         $table->integer('min_pangkat_terakhir')->nullable();;
        //         $table->float('selisih_pangkat')->nullable();
        //         $table->float('selisih_jenjang')->nullable();

        //         //Tanggal
        //         $table->dateTime('tanggal_mulai')->nullable();
        //         $table->dateTime('tanggal_selesai')->nullable();
        //         $table->timestamps();

        //         //Status Tahunan(1)/Bulanan(0)
        //         $table->enum('status_periodik', ['0', '1'])->nullable();
        //         $table->enum('status_selesai', ['0', '1'])->nullable()->default('0');

        //         //Catatan
        //         $table->text('catatan')->nullable();

        //         // Foreign key constraint
        //         $table->foreign('user_id')->references('id')->on('tbl_user_detail')->onDelete('cascade');
        //         $table->foreign('jenjang_id')->references('id')->on('tbl_jenjang_pangkat');
        //         $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
        //         $table->foreign('pangkat_id')->references('id')->on('tbl_pangkat_golongan');
        //         $table->foreign('pangkat_id_terakhir')->references('id')->on('tbl_pangkat_golongan');
        //         $table->foreign('pangkat_id_rekom')->references('id')->on('tbl_pangkat_golongan');
        //     });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_koefisien_poin_performance');
        Schema::dropIfExists('tbl_poin_angka_kredit');
    }
};
