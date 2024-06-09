<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Instansi extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_instansi';

    protected $fillable = [
        'name',
        'description',
        'tipe_instansi_code'
    ];

    public function tipeInstansi()
    {
        $this->belongsTo(TipeInstansi::class, 'tipe_instansi_code', 'code');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(KabKota::class, 'kabupaten_id', 'id');
    }

    public function kota()
    {
        return $this->belongsTo(KabKota::class, 'kota_id', 'id');
    }

    public function kabKota()
    {
        $kab_kota_id = $this->kabupaten_id ?? ($this->kota_id ?? null);
        return $this->belongsTo(KabKota::class, 'kota_id', 'id');
    }
}
