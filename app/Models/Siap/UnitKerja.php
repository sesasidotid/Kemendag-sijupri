<?php

namespace App\Models\Siap;

use App\Enums\TaskStatus;
use App\Models\Formasi\Formasi;
use App\Models\Formasi\FormasiDokumen;
use App\Models\Maintenance\Instansi;
use App\Models\Maintenance\Jabatan;
use App\Models\Maintenance\KabKota;
use App\Models\Maintenance\Provinsi;
use App\Models\Maintenance\Storage;
use App\Models\Maintenance\TipeInstansi;
use App\Models\Maintenance\Wilayah;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class UnitKerja extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_unit_kerja';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'alamat',
        'instansi_id',
        'provinsi_id',
        'kabupaten_id',
        'kota_id',
        'tipe_instansi_code',
        'operasional',
        'wilayah_code',
        'latitude',
        'longitude',
    ];


    public function users()
    {
        return $this->hasMany(User::class)->where('delete_flag', false);
    }

    public function tipeInstansi()
    {
        return $this->belongsTo(TipeInstansi::class, 'tipe_instansi_code', 'code');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
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

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_code', 'code');
    }

    public function formasi()
    {
        return $this->hasMany(Formasi::class, 'unit_kerja_id', 'id')
            ->where('delete_flag', false)
            ->where("inactive_flag", false)
            ->where("task_status", TaskStatus::APPROVE);
    }

    public function formasiDokumen()
    {
        return $this->hasOne(FormasiDokumen::class, 'unit_kerja_id', 'id')->latest('created_at');
    }

    public function formasiDokumenAll()
    {
        return $this->hasMany(FormasiDokumen::class, 'unit_kerja_id', 'id')->orderBy('waktu_pelaksanaan', "DESC");
    }

    public function formasiAll()
    {
        return $this->hasMany(Formasi::class, 'unit_kerja_id', 'id')
            ->where('delete_flag', false);
    }

    public function storage()
    {
        return $this->hasMany(Storage::class, 'association_key', 'id')->where('association', $this->table)->latest("created_at");
    }

    public function statusRekomendasi()
    {
        if ($this->formasi && count($this->formasi) > 0) {
            if ($this->whereHas("formasi", function (Builder $query) {
                $query->where("rekomendasi_flag", false);
            })->first()) {
                return false;
            } else {
                return true;
            }
        } else return null;
    }

    public function formasiList()
    {
        return Jabatan::select('tbl_jabatan.name as jabatan', 'tbl_jabatan.urutan as urutan')
            ->leftJoin('tbl_formasi as tf', 'tf.jabatan_code', '=', 'tbl_jabatan.code')
            ->leftJoin('tbl_formasi_result as tfr', 'tfr.formasi_id', '=', 'tf.id')
            ->leftJoin('tbl_unit_kerja as tuk', function ($join) {
                $join->on('tf.unit_kerja_id', '=', 'tuk.id');
            })
            ->where('tuk.id', '=', $this->id)
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
