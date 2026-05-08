<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_grade', function (Blueprint $table) {
			if (Schema::hasColumn('ukm_grade', 'nb_cat')) {
				$table->string('nb_cat')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'nb_wawancara')) {
				$table->string('nb_wawancara')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'nb_seminar')) {
				$table->string('nb_seminar')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'nb_praktik')) {
				$table->string('nb_praktik')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'nb_portofolio')) {
				$table->string('nb_portofolio')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'jpm')) {
				$table->string('jpm')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'score')) {
				$table->string('score')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'ukt')) {
				$table->string('ukt')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'nb_ukt')) {
				$table->string('nb_ukt')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'ukmsk')) {
				$table->string('ukmsk')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'weight')) {
				$table->string('weight')->nullable(true)->default(null)->change();
			}
			if (Schema::hasColumn('ukm_grade', 'grade')) {
				$table->string('grade')->nullable(true)->default(null)->change();
			}
		});

		
		Schema::table('ukm_exam_grade', function (Blueprint $table) {
			if (Schema::hasColumn('ukm_exam_grade', 'score')) {
				$table->string('score')->nullable(true)->default(null)->change();
			}
		});
	}

	public function down()
	{
	}
};
