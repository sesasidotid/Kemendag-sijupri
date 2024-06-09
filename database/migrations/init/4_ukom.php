<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('tbl_ukom_mansoskul'))
            Schema::create('tbl_ukom_mansoskul', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->float('integritas');
                $table->float('kerjasama');
                $table->float('komunikasi');
                $table->float('orientasi_hasil');
                $table->float('pelayanan_publik');
                $table->float('pengembangan_diri_orang_lain');
                $table->float('mengelola_perubahan');
                $table->float('pengambilan_keputusan');
                $table->float('perekat_bangsa');
                $table->float('score');
                $table->float('jpm');
                $table->string('kategori');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_ukom_teknis'))
            Schema::create('tbl_ukom_teknis', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->float('cat');
                $table->float('wawancara')->default(0);
                $table->float('seminar')->default(0);
                $table->float('praktik')->default(0);
                $table->float('makala')->default(0);
                $table->float('nb_cat')->default(0);
                $table->float('nb_wawancara')->default(0);
                $table->float('nb_seminar')->default(0);
                $table->float('nb_praktik')->default(0);
                $table->float('total_nilai_ukt')->default(0);
                $table->float('nilai_ukt')->default(0);
                $table->float('ukmsk')->default(0);
                $table->float('nilai_akhir')->default(0);
                $table->string('rekomendasi')->default("Tidak Lulus Uji Kompetensi");
                $table->boolean('is_lulus')->default(false);
                $table->float('nilai_bobot');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
            });

        if (!Schema::hasTable('tbl_ukom_periode'))
            Schema::create('tbl_ukom_periode', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->date("periode")->nullable();
                $table->date("tgl_mulai_pendaftaran")->nullable();
                $table->date("tgl_tutup_pendaftaran")->nullable();
                $table->string("task_status")->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(true);

                $table->unsignedBigInteger('announcement_id')->nullable();
                $table->foreign('announcement_id')->references('id')->on('tbl_announcement')->onDelete('set null');
            });

        if (!Schema::hasTable('tbl_ukom'))
            Schema::create('tbl_ukom', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('type')->nullable();
                $table->string('status')->nullable();
                $table->string('jenis')->nullable();

                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip')->nullable();
                $table->string('email')->nullable();
                $table->string('file_rekomendasi')->nullable();
                $table->string('pendidikan')->nullable();
                $table->string('jurusan')->nullable();
                $table->string('angka_kredit')->nullable();
                $table->unsignedBigInteger('ukom_periode_id');
                $table->unsignedBigInteger('ukom_mansoskul_id')->nullable();
                $table->unsignedBigInteger('ukom_teknis_id')->nullable();
                $table->string('jabatan_code')->nullable();
                $table->string('tujuan_jabatan_code');
                $table->string('jenjang_code')->nullable();
                $table->string('tujuan_jenjang_code');
                $table->unsignedBigInteger('instansi_id')->nullable();
                $table->unsignedBigInteger('unit_kerja_id')->nullable();
                $table->json('detail')->nullable();
                $table->string('pendaftaran_code')->default(Str::uuid());

                $table->foreign('ukom_periode_id')->references('id')->on('tbl_ukom_periode');
                $table->foreign('ukom_mansoskul_id')->references('id')->on('tbl_ukom_mansoskul');
                $table->foreign('ukom_teknis_id')->references('id')->on('tbl_ukom_teknis');
                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
                $table->foreign('tujuan_jabatan_code')->references('code')->on('tbl_jabatan');
                $table->foreign('jenjang_code')->references('code')->on('tbl_jenjang');
                $table->foreign('tujuan_jenjang_code')->references('code')->on('tbl_jenjang');
                $table->foreign('instansi_id')->references('id')->on('tbl_instansi');
                $table->foreign('unit_kerja_id')->references('id')->on('tbl_unit_kerja');
            });

        if (!Schema::hasTable('tbl_ukom_jadwal'))
            Schema::create('tbl_ukom_jadwal', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->date('periode_ukom');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('isi_peng')->nullable();
                $table->string('nip')->nullable();
                $table->foreign('nip')->references('nip')->on('tbl_user');
            });

        if (!Schema::hasTable('tbl_ukom_riwayat'))
            Schema::create('tbl_ukom_riwayat', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->date('periode_ukom');
                $table->string('jenis_ukom');
                $table->date('jenis_ujian');
                $table->date('tgl_cat');
                $table->string('hasil_cat');
                $table->integer('nilai_cat');
                $table->date('tgl_wawancara');
                $table->string('hasil_wawancara');
                $table->integer('nilai_wawancara');
                $table->date('tgl_praktek');
                $table->string('hasil_praktek');
                $table->integer('nilai_praktek');
                $table->date('tgl_makala');
                $table->string('hasil_makala');
                $table->integer('nilai_makala');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip')->nullable();

                $table->foreign('nip')->references('nip')->on('tbl_user');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_ukom_mansoskul');
        Schema::dropIfExists('tbl_ukom_teknis');
        Schema::dropIfExists('tbl_ukom_periode');
        Schema::dropIfExists('tbl_ukom');

        Schema::dropIfExists('tbl_ukom_jadwal');
        Schema::dropIfExists('tbl_ukom_riwayat');
    }
};
