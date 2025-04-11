<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SecurityBase\Models\User;
use Eyegil\SijupriMaintenance\Models\Instansi;
use Eyegil\SijupriMaintenance\Models\JenisKelamin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInstansi extends Updatable
{
    use HasFactory;

    protected $table = 'siap_user_instansi';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true, "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $nip;
    #[Column(["type" => "string", "nullable" => true, "foreign" => JenisKelamin::class])]
    private $jenis_kelamin_code;
    #[Column(["type" => "string", "nullable" => true, "foreign" => Instansi::class])]
    private $instansi_id;

    protected $fillable = ['nip', 'jenis_kelamin_code', 'instansi_id'];
    protected $casts = ['id' => 'string'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id', 'id');
    }

    public function instansiType()
    {
        return $this->instansi->instansiType;
    }
}
