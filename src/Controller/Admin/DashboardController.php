<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->redirect($this->adminUrlGenerator->setController(ProjectCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('COOP ADMIN');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Projects', 'fas fa-folder', Project::class);
        yield MenuItem::linkToCrud('Tasks', 'fas fa-list-check', Task::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
    }
}
