<?php

use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('tbl_akp_matrix', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_akp_matrix', 'akp_pelatihan_id')) {
                $table->unsignedBigInteger('akp_pelatihan_id')->nullable();
                $table->foreign('akp_pelatihan_id')->references('id')->on('tbl_akp_pelatihan');
            }
            if (!Schema::hasColumn('tbl_akp_matrix', 'relevansi')) {
                $table->string('relevansi')->nullable();
            }
        });

        Schema::table('tbl_akp', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_akp', 'akp_status')) {
                $table->string('akp_status')->nullable();
            }
            if (!Schema::hasColumn('tbl_akp', 'file_rekomendasi')) {
                $table->string('file_rekomendasi')->nullable();
            }
        });
    }

    public function down()
    {
    }
};
