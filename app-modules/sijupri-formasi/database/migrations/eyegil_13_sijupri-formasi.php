<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriFormasi\Models\Formasi;
use Eyegil\SijupriFormasi\Models\FormasiDetail;
use Eyegil\SijupriFormasi\Models\FormasiDokumen;
use Eyegil\SijupriFormasi\Models\FormasiProsesVerifikasi;
use Eyegil\SijupriFormasi\Models\FormasiResult;
use Eyegil\SijupriFormasi\Models\FormasiScore;
use Eyegil\SijupriFormasi\Models\FormasiUnitKerja;
use Eyegil\SijupriFormasi\Models\Unsur;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Unsur::class)
			->createSchema(Formasi::class)
			->createSchema(FormasiProsesVerifikasi::class)
			->createSchema(FormasiDetail::class)
			->createSchema(FormasiScore::class)
			->createSchema(FormasiResult::class)
			->createSchema(FormasiDokumen::class)
			->createSchema(FormasiUnitKerja::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Unsur::class)
			->createSchema(Formasi::class)
			->createSchema(FormasiDetail::class)
			->createSchema(FormasiProsesVerifikasi::class)
			->createSchema(FormasiScore::class)
			->createSchema(FormasiResult::class)
			->createSchema(FormasiDokumen::class)
			->createSchema(FormasiUnitKerja::class)
			->down();
	}
};
