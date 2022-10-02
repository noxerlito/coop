<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Form\Type\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {
    }

    #[Route('/project/{id}/tasks', name: 'task_list')]
    public function list(Project $project): Response
    {
        $this->denyAccessUnlessGranted('task_list', $project);

        $tasks = $project->getTasks();

        return $this->render('task/list.html.twig', [
            'id' => $project->getId(),
            'tasks' => $tasks,
        ]);
    }

    #[Route('/tasks/{id}', name: 'task_show')]
    public function show(Task $task): Response
    {
        $this->denyAccessUnlessGranted('read', $task);

        return $this->render('task/detail.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/project/{id}/tasks/create', name: 'task_create')]
    public function create(Project $project, Request $request): Response
    {
        $this->denyAccessUnlessGranted('task_create', $project);

        $task = new Task();
        $task->setProject($project);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskRepository->save($task, true);

            return $this->redirectToRoute('task_show', ['id' => $task->getId()]);
        }

        return $this->render('task/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function edit(Task $task, Request $request): Response
    {
        $this->denyAccessUnlessGranted('edit', $task);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskRepository->save($task, true);

            return $this->redirectToRoute('task_show', ['id' => $task->getId()]);
        }

        return $this->render('task/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function delete(Task $task): Response
    {
        $this->denyAccessUnlessGranted('delete', $task);

        $projectId = $task->getProject()->getId();

        $this->taskRepository->remove($task, true);

        return $this->redirectToRoute('task_list', ['id' => $projectId]);
    }
}
