<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserApplicationChannel extends Creatable
{
    use HasFactory;
    protected $table = 'sec_user_application_channel';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $user_id;
    #[Column(["type" => "string", "foreign" => Application::class])]
    private $application_code;
    #[Column(["type" => "string", "foreign" => Channel::class])]
    private $channel_code;

    protected $fillable = ['id', 'user_id', 'application_code', 'channel_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_code', 'id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_code', 'id');
    }
}
