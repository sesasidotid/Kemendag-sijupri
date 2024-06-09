<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_notification_type'))
            Schema::create('tbl_notification_type', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->integer('idx')->default(0);
            });

        if (!Schema::hasTable('tbl_notification_template'))
            Schema::create('tbl_notification_template', function (Blueprint $table) {
                $table->string('code')->primary();
                $table->timestamps();
                $table->string('template');
                $table->string('parent_code')->nullable();;
                $table->string('notification_type_code')->nullable();
                $table->integer('idx')->default(0);

                $table->foreign('notification_type_code')->references('code')->on('tbl_notification_type');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_notification_type');
        Schema::dropIfExists('tbl_notification_template');
    }
};
