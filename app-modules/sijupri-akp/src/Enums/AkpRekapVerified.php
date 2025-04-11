<?php

namespace Eyegil\SijupriAkp\Enums;


enum AkpRekapVerified: string
{
    case EMPTY = "EMPTY";
    case PENDING = "PENDING";
    case REJECT = "REJECT";
    case APPROVE = "APPROVE";
}
