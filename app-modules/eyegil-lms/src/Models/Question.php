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

    #[Column(["type" => "float", "nullable" => true])]
    private $weight;

    #[Column(["type" => "text", "nullable" => true])]
    private $hint;

    #[Column(["type" => "string", "index" => true])]
    private $module_id;

    #[Column(["type" => "string", "foreign" => Question::class, "nullable" => true])]
    private $parent_question_id;

    protected $fillable = ['id', 'question', 'type', 'metadata', 'module_id', 'parent_question_id', 'attachment'];
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

    public function checkList()
    {
        return $this->hasMany(Checklist::class, "question_id", "id");
    }

    public function questionGroup()
    {
        return $this->hasOne(QuestionGroup::class, "question_id", "id");
    }

    public function parentQuestion()
    {
        return $this->belongsTo(Question::class, "parent_question_id", "id");
    }

    public function childQuestionList()
    {
        return $this->hasMany(Question::class, "parent_question_id", "id");
    }
}
