<?php

namespace App\Models\Maintenance;

use App\Models\Siap\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class KabKota extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_kab_kota';

    protected $fillable = [
        'name',
        'description',
        'provinsi_id',
        'latitude',
        'longitude',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function unitkerja()
    {
        if ($this->type == "KABUPATEN")
            return $this->hasMany(UnitKerja::class, 'kabupaten_id', 'id')->where('delete_flag', false);
        else if ($this->type == "KOTA")
            return $this->hasMany(UnitKerja::class, 'kota_id', 'id')->where('delete_flag', false);
        else return null;
    }

    public function formasiList()
    {
        return Jabatan::select('tbl_jabatan.name as jabatan', 'tbl_jabatan.urutan as urutan')
            ->leftJoin('tbl_formasi as tf', 'tf.jabatan_code', '=', 'tbl_jabatan.code')
            ->leftJoin('tbl_formasi_result as tfr', 'tfr.formasi_id', '=', 'tf.id')
            ->leftJoin('tbl_unit_kerja as tuk', 'tf.unit_kerja_id', '=', 'tuk.id')
            ->leftJoin('tbl_kab_kota as tkk', function ($join) {
                $join->on('tuk.kabupaten_id', '=', 'tkk.id')
                    ->on('tuk.kota_id', '=', 'tkk.id');
            })
            ->where('tkk.id', '=', $this->id)
            ->orWhere('tkk.id', '=', $this->id)
            ->selectRaw(
                "COALESCE(SUM(CASE WHEN tfr.jenjang_code = 'pemula' THEN tfr.pembulatan END), 0) AS pemula_sum,
        COALESCE(SUM(CASE WHEN tfr.jenjang_code = 'terampil' THEN tfr.pembulatan END), 0) AS terampil_sum,
        COALESCE(SUM(CASE WHEN tfr.jenjang_code = 'mahir' THEN tfr.pembulatan END), 0) AS mahir_sum,
        COALESCE(SUM(CASE WHEN tfr.jenjang_code = 'penyelia' THEN tfr.pembulatan END), 0) AS penyelia_sum,
        COALESCE(SUM(CASE WHEN tfr.jenjang_code = 'pertama' THEN tfr.pembulatan END), 0) AS pertama_sum,
        COALESCE(SUM(CASE WHEN tfr.jenjang_code = 'muda' THEN tfr.pembulatan END), 0) AS muda_sum,
        COALESCE(SUM(CASE WHEN tfr.jenjang_code = 'madya' THEN tfr.pembulatan END), 0) AS madya_sum,
        COALESCE(SUM(CASE WHEN tfr.jenjang_code = 'utama' THEN tfr.pembulatan END), 0) AS utama_sum"
            )->groupBy('tbl_jabatan.name', 'tbl_jabatan.urutan')
            ->orderBy('tbl_jabatan.urutan', 'asc')
            ->get();
    }
}
