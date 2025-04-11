<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Serializable
{
    use HasFactory;
    protected $table = 'sec_channel';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "string"])]
    private $name;

    protected $fillable = ['code', 'name'];
    public function authenticationType()
    {
        return $this->belongsTo(AuthenticationType::class, 'authentication_type_code', 'code');
    }
}
