<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	public function up()
	{
		Schema::table('ukm_grade', function (Blueprint $table) {
			if (!Schema::hasColumn('ukm_grade', 'updated_by')) {
				$table->string('updated_by')->nullable(true);
			}
			if (!Schema::hasColumn('ukm_grade', 'last_updated')) {
				$table->timestamp('last_updated')->nullable()->index()->useCurrent();
			}
			if (!Schema::hasColumn('ukm_grade', 'version')) {
				$table->integer('version')->default(1);
			}
			if (!Schema::hasColumn('ukm_grade', 'delete_flag')) {
				$table->boolean('delete_flag')->default(false);
			}
			if (!Schema::hasColumn('ukm_grade', 'inactive_flag')) {
				$table->boolean('inactive_flag')->default(false);
			}
		});
	}

	public function down() {}
};
