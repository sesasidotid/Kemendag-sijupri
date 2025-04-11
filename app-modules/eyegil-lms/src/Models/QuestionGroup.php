<?php

namespace Eyegil\EyegilLms\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionGroup extends Creatable
{
    use HasFactory;

    protected $table = 'lms_question_group';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "index" => true])]
    private $association;

    #[Column(["type" => "string", "index" => true])]
    private $association_id;

    #[Column(["type" => "string", "foreign" => Question::class])]
    private $question_id;

    protected $fillable = ['id', 'question', 'type', 'metadata', 'module_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function question()
    {
        return $this->hasMany(Question::class, "question_id", "id");
    }
}
