<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use App\Enums\TaskStatusEnum;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private ProjectRepository $projectRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'admin@coop.com']);

        if (!$user instanceof User) {
            return;
        }

        $project = $this->projectRepository->findOneBy(['name' => 'Coop']);

        if (!$project instanceof Project) {
            return;
        }

        $faker = Factory::create();

        $status = TaskStatusEnum::getClassConstants();

        for ($i = 0; $i < 20; ++$i) {
            $task = new Task();
            $task
                ->setName($faker->sentence('10'))
                ->setDescription($faker->paragraph(5))
                ->setCreatedBy($user)
                ->setAssignedTo($user)
                ->setStatus($status[array_rand($status)])
                ->setProject($project)
            ;

            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ProjectFixtures::class,
        ];
    }
}
