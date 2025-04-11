<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SecurityBase\Models\User;
use Eyegil\SijupriMaintenance\Models\JenisKelamin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExaminerUkom extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_examiner';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "index" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => JenisKelamin::class])]
    private $jenis_kelamin_code;
    #[Column(["type" => "string"])]
    private $nip;
    #[Column(["type" => "string", "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $user_id;

    protected $fillable = ['id', 'phone', 'name', 'email', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin_code', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
