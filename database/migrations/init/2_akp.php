<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('tbl_akp_instrumen'))
            Schema::create('tbl_akp_instrumen', function (Blueprint $table) {
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
                $table->string('jenjang_code');
                $table->string('jabatan_code');

                $table->foreign('jenjang_code')->references('code')->on('tbl_jenjang');
                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
            });

        if (!Schema::hasTable('tbl_akp_pelatihan'))
            Schema::create('tbl_akp_pelatihan', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->text('name');
                $table->text('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('jabatan_code');

                //foreign
                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
            });

        if (!Schema::hasTable('tbl_akp_kompetensi'))
            Schema::create('tbl_akp_kompetensi', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->text('name');
                $table->text('description');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });


        if (!Schema::hasTable('tbl_akp_kategori_pertanyaan'))
            Schema::create('tbl_akp_kategori_pertanyaan', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->text('kategori');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->unsignedBigInteger('akp_instrumen_id');

                $table->foreign('akp_instrumen_id')->references('id')->on('tbl_akp_instrumen');
            });


        if (!Schema::hasTable('tbl_formasi_unsur'))
            Schema::create('tbl_formasi_unsur', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('main_id');
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->text('unsur');
                $table->string('standart_waktu')->nullable();;
                $table->string('satuan_waktu')->nullable();
                $table->string('satuan_hasil')->nullable()->default(1);
                $table->float('standart_hasil')->default(1)->nullable();
                $table->float('luas')->default(1)->nullable();
                $table->float('angka_kredit')->nullable();
                $table->float('konstanta')->nullable();
                $table->string('lvl')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('jenjang_code')->nullable();
                $table->string('jabatan_code');

                $table->foreign('jenjang_code')->references('code')->on('tbl_jenjang');
                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
            });

        if (!Schema::hasTable('tbl_akp_pertanyaan'))
            Schema::create('tbl_akp_pertanyaan', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->text('pertanyaan');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->unsignedBigInteger('akp_kategori_pertanyaan_id');

                //foreign
                $table->foreign('akp_kategori_pertanyaan_id')->references('id')->on('tbl_akp_kategori_pertanyaan');
            });

        if (!Schema::hasTable('tbl_akp'))
            Schema::create('tbl_akp', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('nama_atasan')->nullable();
                $table->string('jabatan_atasan')->nullable();
                $table->string('unit_kerja')->nullable();
                $table->string('alamat_unit_kerja')->nullable();
                $table->string('phone_unit_kerja')->nullable();
                $table->string('tahun_kelulusan')->nullable();
                $table->string('rumpun')->nullable();
                $table->date('tanggal_mulai')->nullable();
                $table->date('tanggal_selesai')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip')->nullable();
                $table->unsignedBigInteger('akp_instrumen_id');
                $table->unsignedBigInteger('pangkat_id')->nullable();
                $table->string('jabatan_code')->nullable();
                $table->string('nama_jabatan')->nullable();
                $table->string('akp_status')->nullable();
                $table->string('file_rekomendasi')->nullable();

                //foreign
                $table->foreign('nip')->references('nip')->on('tbl_user');
                $table->foreign('akp_instrumen_id')->references('id')->on('tbl_akp_instrumen');
                $table->foreign('pangkat_id')->references('id')->on('tbl_pangkat');
                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
            });

        if (!Schema::hasTable('tbl_akp_matrix'))
            Schema::create('tbl_akp_matrix', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                //matrix 1
                $table->string('ybs')->nullable();
                $table->integer('atasan')->nullable();
                $table->integer('rekan')->nullable();
                $table->integer('score_matrix_1')->nullable();
                $table->string('keterangan_matrix_1')->nullable();
                //matrix 2
                $table->boolean('penugasan')->nullable();
                $table->boolean('materi')->nullable();
                $table->string('alasan_materi')->nullable();
                $table->boolean('informasi')->nullable();
                $table->string('alasan_informasi')->nullable();
                $table->boolean('standar')->nullable();
                $table->boolean('metode')->nullable();
                $table->string('penyebab_diskrepansi_utama')->nullable();
                $table->string('jenis_pengembangan_kompetensi')->nullable();
                //matrix 3
                $table->string('waktu')->nullable();
                $table->string('kesulitan')->nullable();
                $table->string('kualitas')->nullable();
                $table->string('pengaruh')->nullable();
                $table->integer('score_matrix_3')->nullable();
                $table->string('kategori_matrix_3')->nullable();
                $table->string('rank_prioritas_matrix_3')->nullable();
                //Rekap
                $table->string('relevansi')->default('Relevan');
                //--
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->unsignedBigInteger('akp_pertanyaan_id');
                $table->unsignedBigInteger('akp_id');
                $table->unsignedBigInteger('akp_pelatihan_id')->nullable();

                //foreign
                $table->foreign('akp_pertanyaan_id')->references('id')->on('tbl_akp_pertanyaan');
                $table->foreign('akp_id')->references('id')->on('tbl_akp');
                $table->foreign('akp_pelatihan_id')->references('id')->on('tbl_akp_pelatihan');
            });

        if (!Schema::hasTable('tbl_akp_kompetensi_pelatihan'))
            Schema::create('tbl_akp_kompetensi_pelatihan', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->unsignedBigInteger('akp_pelatihan_id');
                $table->unsignedBigInteger('akp_kompetensi_id');

                //foreign
                $table->foreign('akp_pelatihan_id')->references('id')->on('tbl_akp_pelatihan');
                $table->foreign('akp_kompetensi_id')->references('id')->on('tbl_akp_kompetensi');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_akp_instrumen');
        Schema::dropIfExists('tbl_akp_pelatihan');
        Schema::dropIfExists('tbl_akp_kompetensi');

        Schema::dropIfExists('tbl_akp_kategori_pertanyaan');
        Schema::dropIfExists('tbl_formasi_unsur');
        Schema::dropIfExists('tbl_akp_pertanyaan');
        Schema::dropIfExists('tbl_akp');
        Schema::dropIfExists('tbl_user_akp');
        Schema::dropIfExists('tbl_akp_matrix');


        Schema::dropIfExists('tbl_akp_kompetensi_pelatihan');
    }
};
