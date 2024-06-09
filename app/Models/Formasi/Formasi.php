<?php

namespace App\Models\Formasi;

use App\Models\Audit\AuditTimeline;
use App\Models\Maintenance\Jabatan;
use App\Models\Siap\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Formasi extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_formasi';

    protected $fillable = [
        'id',
        'unit_kerja_id',
        'jabatan_code',
        'total',
        'inactive_flag',
        'task_status',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function formasiDokumen()
    {
        return $this->belongsTo(FormasiDokumen::class, 'formasi_dokumen_id', 'id')->where('delete_flag', false);
    }

    public function formasiResult()
    {
        return $this->hasMany(FormasiResult::class, 'formasi_id', 'id')->where('delete_flag', false);
    }

    public function formasiScore()
    {
        return $this->hasMany(FormasiScore::class, 'formasi_id', 'id')->where('delete_flag', false);
    }

    public function auditTimeline()
    {
        return $this->hasMany(AuditTimeline::class, 'association_key', 'id')->where('association', $this->table);
    }

    //----------------------------------------------------------------
    public function jenjangResult($jenjang_code)
    {
        foreach ($this->formasiResult as $key => $value) {
            if ($value->jenjang_code == $jenjang_code)
                return $value;
        }
        return null;
    }

    public function jenjangPembulatan($jenjang_code)
    {
        foreach ($this->formasiResult as $key => $value) {
            if ($value->jenjang_code == $jenjang_code) {
                return $value->pembulatan;
            }
        }
        return '';
    }
}
