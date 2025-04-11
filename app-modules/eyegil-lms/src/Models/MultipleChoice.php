<?php

namespace Eyegil\EyegilLms\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\EyegilLms\Enums\Choices;
use Eyegil\EyegilLms\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MultipleChoice extends Updatable
{
    use HasFactory;

    protected $table = 'lms_multi_choice';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "enum" => Choices::class])]
    private $choice_id;

    #[Column(["type" => "string"])]
    private $choice_value;

    #[Column(["type" => "boolean", "default" => false])]
    private $correct;
    #[Column(["type" => "string", "foreign" => Question::class])]
    private $question_id;

    protected $fillable = ['id', 'question', 'type', 'metadata', 'module_id'];
    protected $casts = ['metadata' => 'object'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
