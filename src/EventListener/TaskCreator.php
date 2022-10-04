<?php

namespace App\EventListener;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class TaskCreator
{
    public function __construct(private Security $security)
    {
    }

    public function prePersist(Task $task): void
    {
        if ($task->getCreatedBy() instanceof User) {
            return;
        }

        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedException();
        }

        $task->setCreatedBy($user);
    }
}
