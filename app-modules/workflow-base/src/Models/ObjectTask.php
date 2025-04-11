<?php

namespace Eyegil\WorkflowBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjectTask extends Updatable
{
    use HasFactory;
    protected $table = 'wf_object_task';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "nullable" => true, "index" => true])]
    private $property;

    #[Column(["type" => "json", "nullable" => true])]
    private $object;

    #[Column(["type" => "json", "nullable" => true])]
    private $prev_object;

    #[Column(["type" => "json", "nullable" => true])]
    private $old_object;

    protected $fillable = ['id', 'object', 'prev_object', 'old_object', 'object_id', 'object_status', 'pending_task_id'];
    protected $casts = ['object' => 'object', 'old_object' => 'object', 'prev_object' => 'object'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function objectKeyList()
    {
        return $this->hasMany(ObjectKey::class, 'pending_task_id', 'id');
    }
}
