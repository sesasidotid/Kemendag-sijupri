<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Serializable
{
    use HasFactory;
    protected $table = 'sec_application';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "string"])]
    private $name;
    #[Column(["type" => "integer", "default" => 999])]
    private $idx;

    protected $fillable = ['code', 'name', 'type'];
}
