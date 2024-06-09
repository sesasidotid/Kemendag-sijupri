<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_notification'))
            Schema::create('tbl_notification', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('sender_id');
                $table->string('type'); // MESSAGE | ANNOUNCEMENT

                $table->foreign('sender_id')->references('nip')->on('tbl_user')->onDelete('cascade');
            });

        if (!Schema::hasTable('tbl_message'))
            Schema::create('tbl_message', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('title')->nullable();
                $table->text('content');
                $table->string('sender_id');
                $table->unsignedBigInteger('notification_id')->nullable();

                $table->foreign('sender_id')->references('nip')->on('tbl_user')->onDelete('cascade');
                $table->foreign('notification_id')->references('id')->on('tbl_notification')->onDelete('cascade');
            });

        if (!Schema::hasTable('tbl_announcement'))
            Schema::create('tbl_announcement', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('title')->nullable();
                $table->text('content');
                $table->string('sender_id');
                $table->string('group_code');
                $table->unsignedBigInteger('notification_id')->nullable();

                $table->foreign('sender_id')->references('nip')->on('tbl_user')->onDelete('cascade');
                $table->foreign('group_code')->references('code')->on('tbl_role')->onDelete('cascade');
                $table->foreign('notification_id')->references('id')->on('tbl_notification')->onDelete('cascade');
            });

        if (!Schema::hasTable('tbl_message_recipient'))
            Schema::create('tbl_message_recipient', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->timestamp('read_at')->nullable();
                $table->unsignedBigInteger('message_id');
                $table->string('recipient_id');

                $table->foreign('message_id')->references('id')->on('tbl_message')->onDelete('cascade');
                $table->foreign('recipient_id')->references('nip')->on('tbl_user')->onDelete('cascade');
            });

        if (!Schema::hasTable('tbl_notification_recipient'))
            Schema::create('tbl_notification_recipient', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->timestamp('read_at')->nullable();
                $table->unsignedBigInteger('notification_id');
                $table->string('recipient_id');

                $table->foreign('notification_id')->references('id')->on('tbl_notification')->onDelete('cascade');
                $table->foreign('recipient_id')->references('nip')->on('tbl_user')->onDelete('cascade');
            });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_message_recipient');
        Schema::dropIfExists('tbl_notification_recipient');
        Schema::dropIfExists('tbl_message');
        Schema::dropIfExists('tbl_announcement');
        Schema::dropIfExists('tbl_notification');
    }
};
