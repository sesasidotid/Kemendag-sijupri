<?php

namespace Eyegil\WorkflowBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flows extends Updatable
{
    use HasFactory;
    protected $table = 'ewf_flows';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;

    #[Column(["type" => "json", "nullable" => true])]
    private $flow_list;

    #[Column(["type" => "json", "nullable" => true])]
    private $prev_flow_list;

    protected $fillable = ['code', 'flow_list', 'prev_flow_list'];
    protected $casts = ['flow_list' => 'object', 'prev_flow_list' => 'object'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
