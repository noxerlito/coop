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

    #[Route('/project', name: 'app_project')]
    public function index(): Response
    {
        $projects = $this->projectRepository->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
            'controller_name' => 'ProjectController',
        ]);
    }

    #[Route('/project/add', name: 'app_project_add')]
    public function add(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectRepository->save($project, true);

            return $this->redirectToRoute('app_project');
        }

        return $this->render('project/add.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ProjectController',
        ]);
    }

    #[Route('/project/{idProject}', name: 'app_project_edit')]
    public function edit(int $idProject): Response
    {
        $projects = $this->projectRepository->find($idProject);

        return $this->render('project/edit.html.twig', [
            'project' => $projects,
            'controller_name' => 'ProjectController',
        ]);
    }
}
