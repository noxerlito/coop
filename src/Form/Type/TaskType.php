<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Workflow\TaskStatusManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskType extends AbstractType
{
    public function __construct(
        private TaskStatusManager $statusManager
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $task = $builder->getData();

        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('status', ChoiceType::class, [
                'choices' => $this->statusManager->getAvailableStatus($task),
            ])
            ->add('assignedTo', EntityType::class, [
                'class' => User::class,
                'placeholder' => 'Choose a user',
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Save Task'])
        ;
    }
}
