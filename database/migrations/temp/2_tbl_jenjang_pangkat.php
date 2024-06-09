<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('tbl_jenjang_pangkat'))
            Schema::create('tbl_jenjang_pangkat', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('angka_kredit');
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
                $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
                $table->string('jenjang_code');
                $table->unsignedBigInteger('pangkat_id');

                $table->foreign('jenjang_code')->references('code')->on('tbl_jenjang');
                $table->foreign('pangkat_id')->references('id')->on('tbl_pangkat');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_jenjang_pangkat');
    }
};
