<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\Type\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    public function __construct(
        private ProjectRepository $projectRepository
    ) {
    }

    #[Route('/project', name: 'project_list')]
    public function index(): Response
    {
        $projects = $this->projectRepository->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/project/create', name: 'project_create')]
    public function add(Request $request): Response
    {
        $project = new Project();
        $this->denyAccessUnlessGranted('project_create', $project);
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectRepository->save($project, true);

            return $this->redirectToRoute('project_list');
        }

        return $this->render('project/form.html.twig', [
            'form' => $form->createView(),
            'title' => "Ajout d'un nouveau projet",
        ]);
    }

    #[Route('/project/{id}', name: 'project_show')]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/project/{id}/edit', name: 'project_edit')]
    public function edit(Project $project, Request $request): Response
    {
        $this->denyAccessUnlessGranted('project_edit');

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectRepository->save($project, true);

            return $this->redirectToRoute('project_list');
        }

        return $this->render('project/form.html.twig', [
            'form' => $form->createView(),
                'title' => "Edition d'un projet",
        ]);
    }
}
