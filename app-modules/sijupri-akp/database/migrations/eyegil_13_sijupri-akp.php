<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriAkp\Models\Akp;
use Eyegil\SijupriAkp\Models\AkpRekap;
use Eyegil\SijupriAkp\Models\Instrument;
use Eyegil\SijupriAkp\Models\KategoriInstrument;
use Eyegil\SijupriAkp\Models\Matrix;
use Eyegil\SijupriAkp\Models\Matrix1;
use Eyegil\SijupriAkp\Models\Matrix2;
use Eyegil\SijupriAkp\Models\Matrix3;
use Eyegil\SijupriAkp\Models\Pertanyaan;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Instrument::class)
			->createSchema(KategoriInstrument::class)
			->createSchema(Pertanyaan::class)
			->createSchema(Akp::class)
			->createSchema(Matrix::class)
			->createSchema(Matrix1::class)
			->createSchema(Matrix2::class)
			->createSchema(Matrix3::class)
			->createSchema(AkpRekap::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Instrument::class)
			->createSchema(KategoriInstrument::class)
			->createSchema(Pertanyaan::class)
			->createSchema(Akp::class)
			->createSchema(Matrix::class)
			->createSchema(Matrix1::class)
			->createSchema(Matrix2::class)
			->createSchema(Matrix3::class)
			->createSchema(AkpRekap::class)
			->down();
	}
};
