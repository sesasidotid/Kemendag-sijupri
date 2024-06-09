<?php

use App\Enums\TaskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('tbl_report'))
            Schema::create('tbl_report', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('filename');
                $table->string('file_type');
                $table->string('status')->nullable();
                $table->string('type')->nullable();
                $table->string('report_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->integer('version')->nullable();
                $table->integer('idx')->nullable();
                $table->boolean('delete_flag')->default(false);
                $table->boolean('inactive_flag')->default(false);
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_report');
    }
};
