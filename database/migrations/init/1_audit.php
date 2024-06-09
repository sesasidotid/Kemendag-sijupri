<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_audit_login'))
            Schema::create('tbl_audit_login', function (Blueprint $table) {
                $table->id();
                $table->string('nip');
                $table->string('ip_address');
                $table->string('user_agent');
                $table->timestamp('tgl_login');
                $table->timestamp('tgl_logout')->nullable();
            });

        if (!Schema::hasTable('tbl_audit_aktivitas'))
            Schema::create('tbl_audit_aktivitas', function (Blueprint $table) {
                $table->id();
                $table->string('nip');
                $table->string('name');
                $table->string('method');
                $table->string('ip_address');
                $table->string('user_agent');
                $table->timestamp('tgl_access');
            });

        if (!Schema::hasTable('tbl_audit_timeline'))
            Schema::create('tbl_audit_timeline', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('association');
                $table->string('association_key');
                $table->string('description');
                $table->string('status')->default('SUCCESS'); //SUCCESS || FAILED
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_audit_login');
        Schema::dropIfExists('tbl_audit_aktivitas');
    }
};
