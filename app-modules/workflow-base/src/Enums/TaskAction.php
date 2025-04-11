<?php

namespace Eyegil\WorkflowBase\Enums;

enum TaskAction: string
{
    case APPROVE = "approve";
    case REJECT = "reject";
    case REWORK = "rework";
    case AMEND = "amend";
}
