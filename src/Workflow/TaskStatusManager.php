<?php

namespace App\Workflow;

use App\Entity\Task;
use Symfony\Component\Workflow\WorkflowInterface;

class TaskStatusManager
{
    public function __construct(
        private WorkflowInterface $taskStatusChangeStateMachine
    ) {
    }

    public function getAvailableStatus(Task $task): array
    {
        $enabledTransitions = $this->taskStatusChangeStateMachine->getEnabledTransitions($task);
        $status = [];
        $status[$task->getStatus()] = $task->getStatus();
        foreach ($enabledTransitions as $transition) {
            $status[$transition->getTos()[0]] = $transition->getTos()[0];
        }

        return $status;
    }
}
