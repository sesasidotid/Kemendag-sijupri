<?php

namespace Eyegil\SecurityBase\Enums;

enum UserStatus: string
{
    case ACTIVE = "ACTIVE";
    case NOT_ACTIVE = "NOT_ACTIVE";
    case DELETED = "DELETED";
}
