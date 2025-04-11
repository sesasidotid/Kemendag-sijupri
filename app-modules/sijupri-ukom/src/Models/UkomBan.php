<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkomBan extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_ban';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true, "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $id;
    #[Column(["type" => "timestamp"])]
    private $until;

    protected $fillable = ['id', 'until'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
