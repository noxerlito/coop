<?php

namespace App\Voter;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
{
    private const TASK_LIST = 'task_list';
    private const TASK_CREATE = 'task_create';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::TASK_LIST, self::TASK_CREATE], true)) {
            return false;
        }

        if (!$subject instanceof Project) {
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

        /** @var Project $project */
        $project = $subject;

        return match ($attribute) {
            self::TASK_LIST => $this->canListTasks($project, $user),
            self::TASK_CREATE => $this->canCreateTasks($project, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canListTasks(Project $project, User $user): bool
    {
        return $project->hasUser($user);
    }

    private function canCreateTasks(Project $project, User $user): bool
    {
        return $project->hasUser($user);
    }
}
