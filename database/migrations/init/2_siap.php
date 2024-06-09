<?php

use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_user_akp'))
            Schema::create('tbl_user_akp', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('kategori');
                $table->date('start_date');
                $table->date('end_date');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip');

                $table->foreign('nip')->references('nip')->on('tbl_user');
            });

        if (!Schema::hasTable('tbl_user_jabatan'))
            Schema::create('tbl_user_jabatan', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('tipe_jabatan')->nullable();
                $table->date('tmt');
                $table->string('name');
                $table->string('file_sk_jabatan');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip');
                $table->string('jabatan_code')->nullable();
                $table->string('jenjang_code')->nullable();

                $table->foreign('nip')->references('nip')->on('tbl_user');
                $table->foreign('jabatan_code')->references('code')->on('tbl_jabatan');
                $table->foreign('jenjang_code')->references('code')->on('tbl_jenjang');
            });

        if (!Schema::hasTable('tbl_user_kompetensi'))
            Schema::create('tbl_user_kompetensi', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->string('kategori');
                $table->date('tgl_mulai');
                $table->date('tgl_selesai');
                $table->date('tgl_sertifikat');
                $table->string('file_sertifikat');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip');

                $table->foreign('nip')->references('nip')->on('tbl_user');
            });

        if (!Schema::hasTable('tbl_user_pak'))
            Schema::create('tbl_user_pak', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->integer('periode');
                $table->date('tgl_mulai');
                $table->date('tgl_selesai');
                $table->string('nilai_kinerja');
                $table->string('nilai_perilaku');
                $table->string('predikat');
                $table->float('angka_kredit');
                $table->string('file_doc_ak')->default(false);
                $table->string('file_hasil_eval')->default(false);
                $table->string('file_akumulasi_ak')->default(false);
                $table->string('file_dok_konversi')->default(false);
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip');

                //foreign
                $table->foreign('nip')->references('nip')->on('tbl_user');
            });

        if (!Schema::hasTable('tbl_user_pangkat'))
            Schema::create('tbl_user_pangkat', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->date('tmt');
                $table->string('file_sk_pangkat');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip');
                $table->unsignedBigInteger('pangkat_id');

                $table->foreign('nip')->references('nip')->on('tbl_user');
                $table->foreign('pangkat_id')->references('id')->on('tbl_pangkat');
            });

        if (!Schema::hasTable('tbl_user_pendidikan'))
            Schema::create('tbl_user_pendidikan', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('level');
                $table->string('jurusan');
                $table->string('instansi_pendidikan');
                $table->string('bulan_kelulusan');
                $table->string('file_ijazah');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip');

                $table->foreign('nip')->references('nip')->on('tbl_user');
            });

        if (!Schema::hasTable('tbl_user_sertifikasi'))
            Schema::create('tbl_user_sertifikasi', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('kategori');
                //pegawai berhak
                $table->string('nomor_sk');
                $table->string('tanggal_sk');
                $table->string('file_doc_sk');
                //Penyidik Pegawai Negeri Sipil (PPNS)
                $table->string('uu_kawalan')->nullable();
                $table->string('wilayah_kerja')->nullable();
                $table->string('berlaku_mulai')->nullable();
                $table->string('berlaku_sampai')->nullable();
                $table->string('file_ktp_ppns')->nullable();

                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip');

                $table->foreign('nip')->references('nip')->on('tbl_user');
            });

        if (!Schema::hasTable('tbl_user_ukom'))
            Schema::create('tbl_user_ukom', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('periode');
                // kenaikan jenjang
                // perpindahan jabatan
                // promosi
                $table->string('jenis');
                $table->string('nilai_akhir');
                $table->string('file_rekomendasi')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('nip');

                $table->foreign('nip')->references('nip')->on('tbl_user');
            });

        if (!Schema::hasTable('tbl_user_detail'))
            Schema::create('tbl_user_detail', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string("jenis_kelamin")->nullable();
                $table->string('nik')->nullable();
                $table->string('karpeg')->nullable();
                $table->string('tempat_lahir')->nullable();
                $table->dateTime('tanggal_lahir')->nullable();
                $table->string('email')->nullable();
                $table->string('no_hp')->nullable();
                $table->string('file_ktp')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->unsignedBigInteger("user_pak_id")->nullable();
                $table->unsignedBigInteger("user_akp_id")->nullable();
                $table->unsignedBigInteger("user_pangkat_id")->nullable();
                $table->unsignedBigInteger("user_jabatan_id")->nullable();
                $table->unsignedBigInteger("user_pendidikan_id")->nullable();
                $table->string("nip");

                $table->foreign('nip')->references('nip')->on('tbl_user');
                $table->foreign('user_pak_id')->references('id')->on('tbl_user_pak');
                $table->foreign('user_akp_id')->references('id')->on('tbl_user_akp');
                $table->foreign('user_pangkat_id')->references('id')->on('tbl_user_pangkat');
                $table->foreign('user_jabatan_id')->references('id')->on('tbl_user_jabatan');
                $table->foreign('user_pendidikan_id')->references('id')->on('tbl_user_pendidikan');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_user_akp');
        Schema::dropIfExists('tbl_user_jabatan');
        Schema::dropIfExists('tbl_user_kompetensi');
        Schema::dropIfExists('tbl_user_pak');
        Schema::dropIfExists('tbl_user_pangkat');
        Schema::dropIfExists('tbl_user_pendidikan');
        Schema::dropIfExists('tbl_user_sertifikasi');
        Schema::dropIfExists('tbl_user_detail');

        Schema::dropIfExists('tbl_user_ukom');
    }
};
