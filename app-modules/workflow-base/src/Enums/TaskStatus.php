<?php

namespace Eyegil\WorkflowBase\Enums;

enum TaskStatus: string
{
    case PENDING = "PENDING";
    case APPROVE = "APPROVE";
    case REJECT = "REJECT";
    case COMPLETED = "COMPLETED";
    case FAILED = "FAILED";
}
