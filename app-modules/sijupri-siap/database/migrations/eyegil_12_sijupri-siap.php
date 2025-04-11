<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriSiap\Models\JF;
use Eyegil\SijupriSiap\Models\RiwayatJabatan;
use Eyegil\SijupriSiap\Models\RiwayatKinerja;
use Eyegil\SijupriSiap\Models\RiwayatKompetensi;
use Eyegil\SijupriSiap\Models\RiwayatPangkat;
use Eyegil\SijupriSiap\Models\RiwayatPendidikan;
use Eyegil\SijupriSiap\Models\RiwayatSertifikasi;
use Eyegil\SijupriSiap\Models\UserInstansi;
use Eyegil\SijupriSiap\Models\UserUnitKerja;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(UserInstansi::class)
			->createSchema(UserUnitKerja::class)
			->createSchema(JF::class)
			->createSchema(RiwayatPendidikan::class)
			->createSchema(RiwayatJabatan::class)
			->createSchema(RiwayatPangkat::class)
			->createSchema(RiwayatKinerja::class)
			->createSchema(RiwayatKompetensi::class)
			->createSchema(RiwayatSertifikasi::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(UserInstansi::class)
			->createSchema(UserUnitKerja::class)
			->createSchema(JF::class)
			->createSchema(RiwayatPendidikan::class)
			->createSchema(RiwayatJabatan::class)
			->createSchema(RiwayatPangkat::class)
			->createSchema(RiwayatKinerja::class)
			->createSchema(RiwayatKompetensi::class)
			->createSchema(RiwayatSertifikasi::class)
			->down();
	}
};
