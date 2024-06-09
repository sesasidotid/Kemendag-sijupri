<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Models\Maintenance\TipeInstansi;
use App\Models\Maintenance\Instansi;
use App\Models\Security\Role;
use App\Models\Siap\UnitKerja;
use App\Models\Siap\UserDetail;
use App\Models\Siap\UserJabatan;
use App\Models\Siap\UserKompetensi;
use App\Models\Siap\UserPak;
use App\Models\Siap\UserPangkat;
use App\Models\Siap\UserPendidikan;
use App\Models\Siap\UserSertifikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use stdClass;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'tbl_user';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $fillable = [
        'nip',
        'password',
        'name',
        'user_status',
        'unit_kerja_id',
        'tipe_instansi_code',
        'role_code',
        'app_code',
        'access_method'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'access_method' => 'json',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $access_method = new stdClass();
            $access_method->read = true;
            $access_method->create = true;
            $access_method->update = true;
            $access_method->delete = true;

            $model->access_method = $access_method;
        });
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encrypt(Hash::make($value));
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function tipeInstansi()
    {
        return $this->belongsTo(TipeInstansi::class, 'tipe_instansi_code', 'code');
    }


    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_code', 'code');
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'nip', 'nip');
    }

    public function userPendidikan()
    {
        return $this->hasMany(UserPendidikan::class, 'nip', 'nip')->where('delete_flag', false);
    }

    public function userPendidikanPending()
    {
        return $this->hasMany(UserPendidikan::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::PENDING)->orWhere('task_status', null);
    }

    public function jabatan()
    {
        return $this->hasOne(UserJabatan::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::APPROVE)->latest('tmt');
    }

    public function userJabatan()
    {
        return $this->hasMany(UserJabatan::class, 'nip', 'nip')->where('delete_flag', false);
    }

    public function userJabatanPending()
    {
        return $this->hasMany(UserJabatan::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::PENDING)->orWhere('task_status', null);
    }

    public function pangkat()
    {
        return $this->hasOne(UserPangkat::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::APPROVE)->latest('tmt');
    }

    public function userPangkat()
    {
        return $this->hasMany(UserPangkat::class, 'nip', 'nip')->where('delete_flag', false);
    }

    public function userPangkatPending()
    {
        return $this->hasMany(UserPangkat::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::PENDING)->orWhere('task_status', null);
    }

    public function pak()
    {
        return $this->hasOne(UserPak::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::APPROVE)->latest('tgl_selesai');
    }

    public function userPak()
    {
        return $this->hasMany(UserPak::class, 'nip', 'nip')->where('delete_flag', false);
    }

    public function userPakPending()
    {
        return $this->hasMany(UserPak::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::PENDING)->orWhere('task_status', null);
    }

    public function kompetensi()
    {
        return $this->hasOne(UserKompetensi::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::APPROVE)->latest('tgl_selesai');
    }

    public function userKompetensi()
    {
        return $this->hasMany(UserKompetensi::class, 'nip', 'nip')->where('delete_flag', false);
    }

    public function userKompetensiPending()
    {
        return $this->hasMany(UserKompetensi::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::PENDING)->orWhere('task_status', null);
    }

    public function sertifikasi()
    {
        return $this->hasOne(UserSertifikasi::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::APPROVE)->latest('tanggal_sk');
    }

    public function userSertifikasi()
    {
        return $this->hasMany(UserSertifikasi::class, 'nip', 'nip')->where('delete_flag', false);
    }

    public function userSertifikasiPending()
    {
        return $this->hasMany(UserSertifikasi::class, 'nip', 'nip')->where('delete_flag', false)->where('task_status', TaskStatus::PENDING)->orWhere('task_status', null);
    }

    public function checkJabatan()
    {
        $userJabatan = $this->userJabatan;
        if ($userJabatan->isEmpty())
            return null;

        foreach ($userJabatan as $key => $jabatan) {
            if ($jabatan->task_status == null || $jabatan->task_status == TaskStatus::PENDING) {
                return false;
            }
        }

        return true;
    }
    public function checkPendidikan()
    {
        $userPendidikan = $this->userPendidikan;
        if ($userPendidikan->isEmpty())
            return null;

        foreach ($userPendidikan as $key => $pendidikan) {
            if ($pendidikan->task_status == null || $pendidikan->task_status == TaskStatus::PENDING) {
                return false;
            }
        }

        return true;
    }

    public function checkPangkat()
    {
        if ($this->userPangkat->isEmpty())
            return null;

        foreach ($this->userPangkat as $key => $pangkat) {
            if ($pangkat->task_status == null || $pangkat->task_status == TaskStatus::PENDING) {
                return false;
            }
        }

        return true;
    }

    public function checkKinerja()
    {
        if ($this->userPak->isEmpty())
            return null;

        foreach ($this->userPak as $key => $kinerja) {
            if ($kinerja->task_status == null || $kinerja->task_status == TaskStatus::PENDING) {
                return false;
            }
        }

        return true;
    }

    public function checkKompetensi()
    {
        if ($this->userKompetensi->isEmpty())
            return null;

        foreach ($this->userKompetensi as $key => $komp) {
            if ($komp->task_status == null || $komp->task_status == TaskStatus::PENDING) {
                return false;
            }
        }

        return true;
    }

    public function checkSertifikasi()
    {
        if ($this->userSertifikasi->isEmpty())
            return null;

        foreach ($this->userSertifikasi as $key => $sertifikasi) {
            if ($sertifikasi->task_status == null || $sertifikasi->task_status == TaskStatus::PENDING) {
                return false;
            }
        }
        dd($this->userSertifikasi);

        return true;
    }
}
