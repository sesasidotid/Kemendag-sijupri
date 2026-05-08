<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
	public function up()
	{
		Schema::table('mnt_dokumen_persyaratan', function (Blueprint $table) {
			if (!Schema::hasColumn('mnt_dokumen_persyaratan', 'additional_5')) {
				$table->string('additional_5')->nullable(true)->default(null);
			}
			if (!Schema::hasColumn('mnt_dokumen_persyaratan', column: 'additional_6')) {
				$table->string('additional_6')->nullable(true)->default(null);
			}
			if (!Schema::hasColumn('mnt_dokumen_persyaratan', 'additional_7')) {
				$table->string('additional_7')->nullable(true)->default(null);
			}
		});
	}

	public function down()
	{
	}
};
