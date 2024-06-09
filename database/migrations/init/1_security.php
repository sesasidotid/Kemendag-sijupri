<?php

use App\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_menu'))
            Schema::create('tbl_menu', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->integer('lvl')->default(0);
                $table->integer('idx')->default(0);
                $table->string('routes')->default("");
                $table->string('app_code')->default("USER,PUSBIN")->nullable();
                $table->string('description')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('parent_code')->nullable();
            });

        if (!Schema::hasTable('tbl_role'))
            Schema::create('tbl_role', function (Blueprint $table) {
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

        if (!Schema::hasTable('tbl_role_menu'))
            Schema::create('tbl_role_menu', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('menu_code');
                $table->string('role_code');
                $table->string('description')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);

                $table->foreign('menu_code')->references('code')->on('tbl_menu');
                $table->foreign('role_code')->references('code')->on('tbl_role');
            });

        if (!Schema::hasTable('tbl_user'))
            Schema::create('tbl_user', function (Blueprint $table) {
                $table->string("nip")->primary();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('name');
                $table->text('password');
                $table->string('user_status')->default(UserStatus::ACTIVE);
                $table->string('app_code')->default("USER");
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('tipe_instansi_code')->nullable();
                $table->unsignedBigInteger('unit_kerja_id')->nullable();
                $table->string('role_code');
                $table->json('access_method')->nullable();

                $table->foreign('unit_kerja_id')->references('id')->on('tbl_unit_kerja');
                $table->foreign('role_code')->references('code')->on('tbl_role');
            });

        if (!Schema::hasTable('tbl_user_role'))
            Schema::create('tbl_user_role', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('nip');
                $table->string('role_code');
                $table->string('description')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);

                $table->foreign('nip')->references('nip')->on('tbl_user');
                $table->foreign('role_code')->references('code')->on('tbl_role');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_menu');
        Schema::dropIfExists('tbl_role');
        Schema::dropIfExists('tbl_user_role');

        Schema::dropIfExists('tbl_role_menu');
        Schema::dropIfExists('tbl_user');
    }
};
