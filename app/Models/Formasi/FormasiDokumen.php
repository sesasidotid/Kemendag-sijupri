<?php

namespace App\Models\Formasi;

use App\Models\Audit\AuditTimeline;
use App\Models\Maintenance\Jabatan;
use App\Models\Maintenance\Jenjang;
use App\Models\Maintenance\Storage;
use App\Models\Siap\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FormasiDokumen extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_formasi_dokumen';

    protected $fillable = [
        'file_surat_pengajuan_abk',
        'status_surat_pengajuan_abk',
        'file_struktur_organisasi',
        'status_struktur_organisasi',
        'file_daftar_susunan_pegawai',
        'status_daftar_susunan_pegawai',
        'file_rencana_pemenuhan_kebutuhan_pegawai',
        'status_rencana_pemenuhan_kebutuhan_pegawai',
        'file_potensi_uttp',
        'status_potensi_uttp',
        'unit_kerja_id',
    ];

    public function unitKerja()
    {
        return $this->hasOne(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function formasi()
    {
        return $this->hasMany(Formasi::class, 'formasi_dokumen_id', 'id');
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
