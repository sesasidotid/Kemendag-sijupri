<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratRekomProcess extends Updatable
{
    use HasFactory;

    protected $table = 'mnt_surat_rekom_process';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $type;
    #[Column(["type" => "string"])]
    private $status;
    #[Column(["type" => "string"])]
    private $file_name;

    protected $fillable = ['id', 'type', 'status', 'file_name'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
