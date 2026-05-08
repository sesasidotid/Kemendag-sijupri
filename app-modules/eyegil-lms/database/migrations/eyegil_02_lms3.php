<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('lms_question', function (Blueprint $table) {
			if (!Schema::hasColumn('lms_question', 'parent_question_id')) {
				$table->string('parent_question_id')->nullable()->references('id')->on('lms_question')->onDelete('cascade');
			}
			if (!Schema::hasColumn('lms_question', 'weight')) {
				$table->float('weight')->nullable();
			}
		});
	}

	public function down()
	{
	}
};
