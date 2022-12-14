<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case PENDING = 'En attente';
    case ASSIGNED = 'Assigné';
    case IN_PROGRESS = 'En cours';
    case IN_REVIEW = 'En attente de review';
    case VALIDATED = 'Validé';
    case REJECTED = 'Rejetté';
    case COMPLETED = 'Complété';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function formChoices(): array
    {
        $choices = [];
        foreach (self::cases() as $case) {
            $choices[$case->value] = $case->value;
        }

        return $choices;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
