<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_ukom_periode', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_ukom_periode', 'periode_ukom'))
                $table->dropColumn('periode_ukom');
            if (Schema::hasColumn('tbl_ukom_periode', 'pengumuman_id')) {
                $table->dropForeign(['pengumuman_id']);
                $table->dropColumn('pengumuman_id');
            }
            if (Schema::hasColumn('tbl_ukom_periode', 'nip')) {
                $table->dropForeign(['nip']);
                $table->dropColumn('nip');
            }
            if (Schema::hasColumn('tbl_ukom_periode', 'hasil'))
                $table->dropColumn('hasil');
            if (Schema::hasColumn('tbl_ukom_periode', 'judul'))
                $table->dropColumn('judul')->nullable();
            if (Schema::hasColumn('tbl_ukom_periode', 'content'))
                $table->dropColumn('content')->nullable();

            if (!Schema::hasColumn('tbl_ukom_periode', 'periode'))
                $table->date('periode');
            if (!Schema::hasColumn('tbl_ukom_periode', 'tgl_mulai_pendaftaran'))
                $table->date('tgl_mulai_pendaftaran');
            if (!Schema::hasColumn('tbl_ukom_periode', 'tgl_tutup_pendaftaran'))
                $table->date('tgl_tutup_pendaftaran');
            if (!Schema::hasColumn('tbl_ukom_periode', 'inactive_flag'))
                $table->boolean('inactive_flag')->default(true)->change();
            if (!Schema::hasColumn('tbl_ukom_periode', 'announcement_id')) {
                $table->unsignedBigInteger('announcement_id')->nullable()->unsigned();
                $table->foreign('announcement_id')->references('id')->on('tbl_announcement')->onDelete('set null');
            }
        });



        Schema::table('tbl_ukom_mansoskul', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_ukom_mansoskul', 'score'))
                $table->float('score');
            if (!Schema::hasColumn('tbl_ukom_mansoskul', 'jpm'))
                $table->float('jpm');
            if (!Schema::hasColumn('tbl_ukom_mansoskul', 'kategori'))
                $table->string('kategori');

            if (Schema::hasColumn('tbl_ukom_mansoskul', 'user_ukom_id')) {
                $table->dropForeign(['user_ukom_id']);
                $table->dropColumn('user_ukom_id');
            }
        });

        Schema::table('tbl_ukom_teknis', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_ukom_teknis', 'user_ukom_id')) {
                $table->dropForeign(['user_ukom_id']);
                $table->dropColumn('user_ukom_id');
            }
            if (!Schema::hasColumn('tbl_ukom_teknis', 'seminar'))
                $table->float('seminar')->default(0);


            if (!Schema::hasColumn('tbl_ukom_teknis', 'nb_cat'))
                $table->float('nb_cat')->default(0);
            if (!Schema::hasColumn('tbl_ukom_teknis', 'nb_wawancara'))
                $table->float('nb_wawancara')->default(0);
            if (!Schema::hasColumn('tbl_ukom_teknis', 'nb_seminar'))
                $table->float('nb_seminar')->default(0);
            if (!Schema::hasColumn('tbl_ukom_teknis', 'nb_praktik'))
                $table->float('nb_praktik')->default(0);
            if (!Schema::hasColumn('tbl_ukom_teknis', 'total_nilai_ukt'))
                $table->float('total_nilai_ukt')->default(0);
            if (!Schema::hasColumn('tbl_ukom_teknis', 'nilai_ukt'))
                $table->float('nilai_ukt')->default(0);
            if (!Schema::hasColumn('tbl_ukom_teknis', 'ukmsk'))
                $table->float('ukmsk')->default(0);
            if (!Schema::hasColumn('tbl_ukom_teknis', 'nilai_akhir'))
                $table->float('nilai_akhir')->default(0);
            if (!Schema::hasColumn('tbl_ukom_teknis', 'rekomendasi'))
                $table->string('rekomendasi')->default("Tidak Lulus Uji Kompetensi");
            if (!Schema::hasColumn('tbl_ukom_teknis', 'is_lulus'))
                $table->double('is_lulus')->default(false);
        });

        Schema::table('tbl_ukom', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_ukom', 'tipe_ukom'))
                $table->dropColumn('tipe_ukom');
            if (Schema::hasColumn('tbl_ukom', 'jenis_ukom'))
                $table->dropColumn('jenis_ukom');
            if (Schema::hasColumn('tbl_ukom', 'puncak_jenjang'))
                $table->dropColumn('puncak_jenjang');
            if (Schema::hasColumn('tbl_ukom', 'ukom_jadwal_id')) {
                $table->dropForeign(['ukom_jadwal_id']);
                $table->dropColumn('ukom_jadwal_id');
            }
            if (Schema::hasColumn('tbl_ukom', 'periode_ukom')) {
                $table->dropForeign(['periode_ukom']);
                $table->dropColumn('periode_ukom');
            }
            if (Schema::hasColumn('tbl_ukom', 'sanggah'))
                $table->dropColumn('sanggah');
            if (Schema::hasColumn('tbl_ukom', 'jenjang_tujuan')) {
                $table->dropForeign(['jenjang_tujuan']);
                $table->dropColumn('jenjang_tujuan');
            }

            if (!Schema::hasColumn('tbl_ukom', 'pendaftaran_code'))
                $table->string('pendaftaran_code')->default(Str::uuid());
            if (!Schema::hasColumn('tbl_ukom', 'detail'))
                $table->json('detail')->nullable();
            if (!Schema::hasColumn('tbl_ukom', 'file_rekomendasi'))
                $table->string('file_rekomendasi')->nullable();
            if (!Schema::hasColumn('tbl_ukom', 'pendidikan'))
                $table->string('pendidikan')->nullable();
            if (!Schema::hasColumn('tbl_ukom', 'jurusan'))
                $table->string('jurusan')->nullable();
            if (!Schema::hasColumn('tbl_ukom', 'angka_kredit'))
                $table->string('angka_kredit')->nullable();
            if (!Schema::hasColumn('tbl_ukom', 'email'))
                $table->string('email')->nullable();
            if (!Schema::hasColumn('tbl_ukom', 'type'))
                $table->string('type')->nullable();
            if (!Schema::hasColumn('tbl_ukom', 'jenis'))
                $table->string('jenis')->nullable();
            if (!Schema::hasColumn('tbl_ukom', 'nip'))
                $table->string('nip');
            if (!Schema::hasColumn('tbl_ukom', 'name'))
                $table->string('name');
            if (!Schema::hasColumn('tbl_ukom', 'status'))
                $table->string('status');
            if (!Schema::hasColumn('tbl_ukom', 'ukom_periode_id')) {
                $table->unsignedBigInteger('ukom_periode_id')->unsigned();
                $table->foreign('ukom_periode_id')->references('id')->on('tbl_ukom_periode');
            }
            if (!Schema::hasColumn('tbl_ukom', 'ukom_mansoskul_id')) {
                $table->unsignedBigInteger('ukom_mansoskul_id')->nullable()->unsigned();
                $table->foreign('ukom_mansoskul_id')->references('id')->on('tbl_ukom_mansoskul');
            }
            if (!Schema::hasColumn('tbl_ukom', 'ukom_teknis_id')) {
                $table->unsignedBigInteger('ukom_teknis_id')->nullable()->unsigned();
                $table->foreign('ukom_teknis_id')->references('id')->on('tbl_ukom_teknis');
            }
            if (!Schema::hasColumn('tbl_ukom', 'jabatan_code')) {
                $table->string('jabatan_code')->nullable();
                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
            }
            if (!Schema::hasColumn('tbl_ukom', 'tujuan_jabatan_code')) {
                $table->string('tujuan_jabatan_code')->nullable();;
                $table->foreign('tujuan_jabatan_code')->references('code')->on('tbl_jabatan');
            }
            if (!Schema::hasColumn('tbl_ukom', 'jenjang_code')) {
                $table->string('jenjang_code')->nullable();
                $table->foreign('jenjang_code')->references('code')->on('tbl_jenjang');
            }
            if (!Schema::hasColumn('tbl_ukom', 'tujuan_jenjang_code')) {
                $table->string('tujuan_jenjang_code')->nullable();;
                $table->foreign('tujuan_jenjang_code')->references('code')->on('tbl_jenjang');
            }
            if (!Schema::hasColumn('tbl_ukom', 'instansi_id')) {
                $table->unsignedBigInteger('instansi_id')->nullable();
                $table->foreign('instansi_id')->references('id')->on('tbl_instansi');
            }
            if (!Schema::hasColumn('tbl_ukom', 'unit_kerja_id')) {
                $table->unsignedBigInteger('unit_kerja_id')->nullable();
                $table->foreign('unit_kerja_id')->references('id')->on('tbl_unit_kerja');
            }
        });
    }

    public function down()
    {
    }
};
