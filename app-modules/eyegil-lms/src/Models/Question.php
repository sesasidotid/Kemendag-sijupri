<?php

namespace Eyegil\EyegilLms\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\EyegilLms\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Updatable
{
    use HasFactory;

    protected $table = 'lms_question';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "text"])]
    private $question;

    #[Column(["type" => "string", "enum" => QuestionType::class])]
    private $type;

    #[Column(["type" => "string", "nullable" => true])]
    private $attachment;

    #[Column(["type" => "string", "index" => true])]
    private $module_id;

    protected $fillable = ['id', 'question', 'type', 'metadata', 'module_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
    public function answer()
    {
        return $this->hasMany(Answer::class, "question_id", "id");
    }

    public function choices()
    {
        return $this->hasMany(MultipleChoice::class, "question_id", "id");
    }

    public function questionGroup() {
        return $this->hasOne(QuestionGroup::class, "question_id", "id");
    }
}
