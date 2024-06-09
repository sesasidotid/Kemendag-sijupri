<?php

namespace App\Models\Ukom;

use App\Models\Audit\AuditTimeline;
use App\Models\Maintenance\Instansi;
use App\Models\Maintenance\Jabatan;
use App\Models\Maintenance\Jenjang;
use App\Models\Maintenance\Pangkat;
use App\Models\Maintenance\Storage;
use App\Models\Siap\UnitKerja;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ukom extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_ukom';
    protected $fillable = [
        'type',
        'status',
        'jenjang_tujuan',
        'delete_flag',
        'inactive_flag',
        'task_status',
        'comment',
        'nip',
        'ukom_periode_id',
        'jabatan_code',
        'tujuan_jabatan_code',
        'jenjang_code',
        'tujuan_jenjang_code',
        'instansi_id',
        'unit_kerja_id',
        'pendaftaran_code',
    ];

    protected $casts = [
        'detail' => 'json',
    ];

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($key === 'detail') {
            return (object) $value;
        }

        return $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }

    public function tujuanJenjang()
    {
        return $this->belongsTo(Jenjang::class, 'tujuan_jenjang_code', 'code');
    }

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class);
    }

    public function tujuanPangkat()
    {
        return $this->belongsTo(Pangkat::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function tujuanJabatan()
    {
        return $this->belongsTo(Jabatan::class, 'tujuan_jabatan_code', 'code');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function ukomPeriode()
    {
        return $this->belongsTo(UkomPeriode::class);
    }

    public function ukomMansoskul()
    {
        return $this->belongsTo(UkomMansoskul::class);
    }

    public function ukomTeknis()
    {
        return $this->belongsTo(UkomTeknis::class);
    }

    public function storage()
    {
        return $this->hasMany(Storage::class, 'association_key', 'id')->where('association', $this->table);
    }

    public function auditTimeline()
    {
        return $this->hasMany(AuditTimeline::class, 'association_key', 'id')->where('association', $this->table);
    }
}
