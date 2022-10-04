<?php

namespace App\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    private const READ = 'task_read';
    private const EDIT = 'task_edit';
    private const DELETE = 'task_delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::READ, self::EDIT, self::DELETE], true)) {
            return false;
        }

        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Task $task */
        $task = $subject;

        return match ($attribute) {
            self::READ => $this->canRead($task, $user),
            self::EDIT => $this->canEdit($task, $user),
            self::DELETE => $this->canDelete($task, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canRead(Task $task, User $user): bool
    {
        return $task->getProject()->hasUser($user);
    }

    private function canEdit(Task $task, User $user): bool
    {
        return $task->getProject()->hasUser($user);
    }

    private function canDelete(Task $task, User $user): bool
    {
        return $user === $task->getCreatedBy();
    }
}
