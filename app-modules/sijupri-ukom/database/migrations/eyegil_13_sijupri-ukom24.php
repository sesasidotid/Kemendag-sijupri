<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriUkom\Enums\ExamStatus;
use Eyegil\SijupriUkom\Models\UkomRegistrationRules;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
	public function up()
	{
		Schema::table('ukm_grade', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_grade', 'nb_studi_kasus')) {
				$table->double('nb_studi_kasus')->nullable();
			}
			if (!Schema::hasColumn('ukm_grade', 'studi_kasus_grade_id')) {
				$table->string('studi_kasus_grade_id')->references('id')->on('ukm_exam_grade')->onDelete('cascade');
			}
		});

		Schema::table('ukm_formula', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_formula', 'studi_kasus_percentage')) {
				$table->double('studi_kasus_percentage')->default(100);
			}
		});

		Schema::table('ukm_participant', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_participant', 'grade_visibility')) {
				$table->boolean('grade_visibility')->default(false);
			}
		});
	}

	public function down()
	{
	}
};
