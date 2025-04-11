<?php

namespace Eyegil\WorkflowBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessInstance extends Updatable
{
    use HasFactory;
    protected $table = 'ewf_process_instance';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "nullable" => false])]
    private $workflow_id;

    #[Column(["type" => "string", "nullable" => false])]
    private $current_element_id;

    #[Column(["type" => "string", "nullable" => true])]
    private $current_flow_name;

    #[Column(["type" => "boolean", "default" => false])]
    private $is_completed;

    #[Column(["type" => "json", "nullable" => false])]
    private $workflow_data;

    #[Column(["type" => "json", "nullable" => true])]
    private $current_variables;

    protected $fillable = ['id', 'workflow_id', 'workflow_data', 'current_element_id', 'current_variables'];
    protected $casts = ['workflow_data' => 'array', 'variables' => 'array'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
