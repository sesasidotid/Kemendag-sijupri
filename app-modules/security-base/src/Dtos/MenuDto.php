<?php

namespace Eyegil\SecurityBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class MenuDto extends BaseDto
{
    public $code;
    public $parent_menu_code;
    public $application_code;
    public $name;
    public $description;
    public $child;
    public $path;

    //
    public $is_creatable;
    public $is_updatable;
    public $is_deletable;

    // 
    public $checked = false;
}
