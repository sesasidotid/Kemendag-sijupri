<?php

namespace Eyegil\EyegilLms\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checklist extends Updatable
{
    use HasFactory;

    protected $table = 'lms_checklist';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string"])]
    private $list_id;

    #[Column(["type" => "boolean"])]
    private $checked;
    
    #[Column(["type" => "string", "foreign" => Question::class])]
    private $question_id;

    protected $fillable = ['id', 'question', 'type', 'metadata', 'module_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
