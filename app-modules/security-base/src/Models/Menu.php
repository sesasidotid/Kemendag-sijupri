<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Metadata
{
    use HasFactory;
    protected $table = 'sec_menu';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "integer"])]
    private $level;
    #[Column(["type" => "string"])]
    private $path;
    #[Column(["type" => "string"])]
    private $url;
    #[Column(["type" => "string", "nullable" => true, "index" => true])]
    private $parent_menu_code;
    #[Column(["type" => "string", "foreign" => Application::class])]
    private $application_code;

    protected $fillable = ['code', 'level', 'path', 'url', 'parent_menu_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_code', 'code');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_menu_code', 'code');
    }

    public function child()
    {
        return $this->hasMany(Menu::class, 'parent_menu_code', 'code')->orderBy("idx", "ASC");
    }

    public function roleMenu()
    {
        return $this->hasMany(RoleMenu::class, 'menu_code', 'code');
    }
}
