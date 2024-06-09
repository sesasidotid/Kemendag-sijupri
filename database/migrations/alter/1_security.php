<?php

use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('tbl_role', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_role', 'modul_code'))
                $table->dropColumn('modul_code');

            if (!Schema::hasColumn('tbl_role', 'tipe'))
                $table->string('tipe');
            if (!Schema::hasColumn('tbl_role', 'base'))
                $table->string('base')->nullable();
        });

        Schema::table('tbl_user', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_user', 'instansi_id')) {
                $table->unsignedBigInteger('instansi_id')->nullable();
                $table->foreign('instansi_id')->references('id')->on('tbl_instansi');
            }
            if (!Schema::hasColumn('tbl_user', 'access_method')) {
                $table->json('access_method')->nullable();
            }
        });
    }

    public function down()
    {
    }
};
