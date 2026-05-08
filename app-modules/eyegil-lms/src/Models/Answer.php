<?php

namespace Eyegil\EyegilLms\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\EyegilLms\Enums\Choices;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Updatable
{
    use HasFactory;

    protected $table = 'lms_answer';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "text", "nullable" => true])]
    private $answer_text;
    #[Column(["type" => "text", "nullable" => true])]
    private $answer_upload;
    #[Column(["type" => "text", "nullable" => true, "enum" => Choices::class])]
    private $answer_choice;
    #[Column(["type" => "text", "nullable" => true])]
    private $answer_list;
    #[Column(["type" => "float", "nullable" => true])]
    private $score;
    #[Column(["type" => "boolean", "default" => false])]
    private $is_uncertain;
    #[Column(["type" => "string", "index" => true])]
    private $participant_id;
    #[Column(["type" => "string", "foreign" => Question::class])]
    private $question_id;

    protected $casts = [
        'answer_list' => 'array',
    ];

    protected $fillable = ['id', 'answer', 'type', 'metadata', 'participant_id', 'question_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
    public function question()
    {
        return $this->belongsTo(Question::class, "question_id", "id");
    }
}
