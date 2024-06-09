<?php

namespace App\Models\Maintenance;

use App\Models\Siap\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Provinsi extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_provinsi';

    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
    ];

    public function kabkota()
    {
        return $this->hasMany(KabKota::class, 'provinsi_id', 'id')->where('delete_flag', false);
    }

    public function unitkerja()
    {
        return $this->hasMany(UnitKerja::class, 'provinsi_id', 'id')->where('delete_flag', false);
    }

    public function formasiList()
    {
        return Jabatan::select('tbl_jabatan.name as jabatan', 'tbl_jabatan.urutan as urutan')
            ->leftJoin('tbl_formasi as tf', 'tf.jabatan_code', '=', 'tbl_jabatan.code')
            ->leftJoin('tbl_formasi_result as tfr', 'tfr.formasi_id', '=', 'tf.id')
            ->leftJoin('tbl_unit_kerja as tuk', 'tf.unit_kerja_id', '=', 'tuk.id')
            ->leftJoin('tbl_provinsi as tp', function ($join) {
                $join->on('tuk.provinsi_id', '=', 'tp.id');
            })
            ->where('tp.id', '=', $this->id)
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
