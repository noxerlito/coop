<?php

namespace App\Enums;

use App\Traits\ClassConstHelperTrait;

class TaskStatusEnum
{
    use ClassConstHelperTrait;

    public const PENDING = 'En attente';
    public const ASSIGNED = 'Assigné';
    public const IN_PROGRESS = 'En cours';
    public const IN_REVIEW = 'En attente de review';
    public const VALIDATED = 'Validé';
    public const REJECTED = 'Rejetté';
    public const COMPLETED = 'Complété';
}
