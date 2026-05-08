<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\SijupriMaintenance\Models\DokumenPersyaratan;
use Eyegil\SijupriMaintenance\Models\AngkaKreditJenjang;
use Eyegil\SijupriMaintenance\Models\AngkaKreditKoefisien;
use Eyegil\SijupriMaintenance\Models\AngkaKreditPangkat;
use Eyegil\SijupriMaintenance\Models\BidangJabatan;
use Eyegil\SijupriMaintenance\Models\Instansi;
use Eyegil\SijupriMaintenance\Models\InstansiType;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\JabatanJenjang;
use Eyegil\SijupriMaintenance\Models\JenisKelamin;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Eyegil\SijupriMaintenance\Models\KabupatenKota;
use Eyegil\SijupriMaintenance\Models\KategoriPengembangan;
use Eyegil\SijupriMaintenance\Models\KategoriSertifikasi;
use Eyegil\SijupriMaintenance\Models\Pangkat;
use Eyegil\SijupriMaintenance\Models\PangkatJenjang;
use Eyegil\SijupriMaintenance\Models\PelatihanTeknis;
use Eyegil\SijupriMaintenance\Models\Pendidikan;
use Eyegil\SijupriMaintenance\Models\PendidikanPangkat;
use Eyegil\SijupriMaintenance\Models\PeriodePendaftaran;
use Eyegil\SijupriMaintenance\Models\PredikatKinerja;
use Eyegil\SijupriMaintenance\Models\Provinsi;
use Eyegil\SijupriMaintenance\Models\RatingKinerja;
use Eyegil\SijupriMaintenance\Models\SuratRekomProcess;
use Eyegil\SijupriMaintenance\Models\SuratRekomTemplate;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Eyegil\SijupriMaintenance\Models\Wilayah;
use Eyegil\SijupriMaintenance\Models\Kompetensi;
use Eyegil\SijupriMaintenance\Models\KompetensiIndikator;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(SuratRekomTemplate::class)
			->createSchema(SuratRekomProcess::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(SuratRekomTemplate::class)
			->createSchema(SuratRekomProcess::class)
			->down();
	}
};
