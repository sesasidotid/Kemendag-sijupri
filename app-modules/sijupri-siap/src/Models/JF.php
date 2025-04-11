<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SecurityBase\Models\User;
use Eyegil\SijupriMaintenance\Models\JenisKelamin;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\PendingTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JF extends Updatable
{
    use HasFactory;

    protected $table = 'siap_jf';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true, "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $nip;
    #[Column(["type" => "string", "nullable" => true])]
    private $nik;
    #[Column(["type" => "string", "nullable" => true])]
    private $tempat_lahir;
    #[Column(["type" => "date", "nullable" => true])]
    private $tanggal_lahir;
    #[Column(["type" => "string", "nullable" => true])]
    private $ktp;
    #[Column(["type" => "string", "nullable" => true, "foreign" => JenisKelamin::class])]
    private $jenis_kelamin_code;
    #[Column(["type" => "string", "foreign" => UnitKerja::class])]
    private $unit_kerja_id;

    protected $fillable = ['nip', 'nik', 'tempat_lahir', 'tanggal_lahir', 'ktp', 'jenis_kelamin_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'id');
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function instansi()
    {
        return $this->unitKerja->instansi();
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class, 'jenis_kelamin_code', 'code');
    }

    public function riwayatJabatan()
    {
        return $this->hasOne(RiwayatJabatan::class, 'nip', 'nip')->latest('tmt');
    }

    public function riwayatJabatanList()
    {
        return $this->hasMany(RiwayatJabatan::class, 'nip', 'nip');
    }

    public function riwayatKinerja()
    {
        return $this->hasOne(RiwayatKinerja::class, 'nip', 'nip')->latest('date_end');
    }

    public function riwayatKinerjaList()
    {
        return $this->hasMany(RiwayatKinerja::class, 'nip', 'nip');
    }

    public function riwayatKompetensi()
    {
        return $this->hasOne(RiwayatKompetensi::class, 'nip', 'nip')->latest('tgl_sertifikat');
    }

    public function riwayatKompetensiList()
    {
        return $this->hasMany(RiwayatKompetensi::class, 'nip', 'nip');
    }

    public function riwayatPangkat()
    {
        return $this->hasOne(RiwayatPangkat::class, 'nip', 'nip')->latest('tmt');
    }

    public function riwayatPangkatList()
    {
        return $this->hasMany(RiwayatPangkat::class, 'nip', 'nip');
    }

    public function riwayatPendidikan()
    {
        return $this->hasOne(RiwayatPendidikan::class, 'nip', 'nip')->latest('tanggal_ijazah');
    }

    public function riwayatPendidikanList()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'nip', 'nip');
    }

    public function riwayatSertifikasi()
    {
        return $this->hasOne(RiwayatSertifikasi::class, 'nip', 'nip')->latest('date_end');
    }

    public function riwayatSertifikasiList()
    {
        return $this->hasMany(RiwayatSertifikasi::class, 'nip', 'nip');
    }

    public function pendingTask()
    {
        return $this->hasOne(PendingTask::class, 'object_group', 'nip')->where("task_status", TaskStatus::PENDING->name);
    }
}
