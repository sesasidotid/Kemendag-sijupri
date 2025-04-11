<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SecurityBase\Models\User;
use Eyegil\SijupriMaintenance\Models\BidangJabatan;
use Eyegil\SijupriMaintenance\Models\Instansi;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\JenisKelamin;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Eyegil\SijupriMaintenance\Models\KabupatenKota;
use Eyegil\SijupriMaintenance\Models\Pangkat;
use Eyegil\SijupriMaintenance\Models\Pendidikan;
use Eyegil\SijupriMaintenance\Models\PredikatKinerja;
use Eyegil\SijupriMaintenance\Models\Provinsi;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParticipantUkom extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_participant';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $name;
    #[Column(["type" => "string"])]
    private $phone;
    #[Column(["type" => "string"])]
    private $email;
    #[Column(["type" => "string"])]
    private $tanggal_lahir;
    #[Column(["type" => "string"])]
    private $participant_status;




    #[Column(["type" => "string", "nullable" => true])]
    private $no_surat_usulan;

    #[Column(["type" => "date", "nullable" => true])]
    private $tgl_surat_usulan;

    #[Column(["type" => "string", "nullable" => true, "foreign" => Pendidikan::class])]
    private $pendidikan_terakhir_code;

    #[Column(["type" => "string", "nullable" => true])]
    private $jurusan;

    #[Column(["type" => "string", "nullable" => true, "foreign" => PredikatKinerja::class])]
    private $predikat_kinerja_1_id;

    #[Column(["type" => "string", "nullable" => true, "foreign" => PredikatKinerja::class])]
    private $predikat_kinerja_2_id;

    #[Column(["type" => "boolean", "default" => false])]
    private $is_mengulang;


    #[Column(["type" => "string", "default" => false])]
    private $jenis_instansi;

    #[Column(["type" => "string", "nullable" => true, "foreign" => Provinsi::class])]
    private $provinsi_id;

    #[Column(["type" => "string", "nullable" => true, "foreign" => KabupatenKota::class])]
    private $kabupaten_kota_id;

    #[Column(["type" => "string", "nullable" => true, "foreign" => Pangkat::class])]
    private $pangkat_code;




    #[Column(["type" => "string"])]
    private $jenis_ukom;
    #[Column(["type" => "string", "nullable" => true])]
    private $rekomendasi;
    #[Column(["type" => "string"])]
    private $jabatan_name;
    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $next_jabatan_code;
    #[Column(["type" => "string"])]
    private $jenjang_name;
    #[Column(["type" => "string", "foreign" => Jenjang::class])]
    private $next_jenjang_code;
    #[Column(["type" => "string", "nullable" => true, "foreign" => UnitKerja::class, 'cascade' => ['DELETE']])]
    private $unit_kerja_id;
    #[Column(["type" => "string", "nullable" => true])]
    private $unit_kerja_name;
    #[Column(["type" => "string", "nullable" => false, "foreign" => BidangJabatan::class])]
    private $bidang_jabatan_code;
    #[Column(["type" => "string", "index" => true])]
    private $nip;
    #[Column(["type" => "string", "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $user_id;

    protected $fillable = ['id', 'nip', 'nik', 'name', 'email', 'jenis_ukom', 'rekomendasi', 'next_jabatan_code', 'next_jenjang_code', 'unit_kerja_id', 'unit_kerja_name', 'bidang_jabatan_code', 'user_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class, 'jenis_kelamin_code', 'code');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function nextJabatan()
    {
        return $this->belongsTo(Jabatan::class, 'next_jabatan_code', 'code');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }

    public function nextJenjang()
    {
        return $this->belongsTo(Jenjang::class, 'next_jenjang_code', 'code');
    }

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class, 'pangkat_code', 'code');
    }

    public function bidangJabatan()
    {
        return $this->belongsTo(BidangJabatan::class, 'bidang_jabatan_code', 'code');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id', 'id');
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function ukomBan()
    {
        return $this->hasOne(UkomBan::class, "id", "id");
    }

    public function participantRoomUkom()
    {
        return $this->hasOne(ParticipantRoomUkom::class, "participant_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function examGradeList()
    {
        return $this->hasMany(ExamGrade::class, "participant_id", "id");
    }

    public function pendidikanTerakhir()
    {
        return $this->belongsTo(Pendidikan::class, "pendidikan_terakhir_code", "code");
    }

    public function predikatKinerja1()
    {
        return $this->belongsTo(PredikatKinerja::class, "predikat_kinerja_1_id", "id");
    }

    public function predikatKinerja2()
    {
        return $this->belongsTo(PredikatKinerja::class, "predikat_kinerja_2_id", "id");
    }

    public function provinsi() {
        return $this->belongsTo(Provinsi::class, "provinsi_id", "id");
    }

    public function kabupatenKota() {
        return $this->belongsTo(KabupatenKota::class, "kabupaten_kota_id", "id");
    }
}
