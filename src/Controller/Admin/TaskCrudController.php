<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Enums\TaskStatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['updatedAt' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            AssociationField::new('project')->autocomplete(),
            TextField::new('name'),
            TextEditorField::new('description')->hideOnIndex(),
            AssociationField::new('createdBy')->setDisabled()->hideOnForm(),
            AssociationField::new('assignedTo')->autocomplete(),
            ChoiceField::new('status')
                ->setChoices(TaskStatusEnum::formChoices())
                ->autocomplete(),
            DateTimeField::new('createdAt')->setFormat('d/MM/Y HH:mm:ss')->setDisabled(),
            DateTimeField::new('updatedAt')->setFormat('d/MM/Y HH:mm:ss')->setDisabled(),
        ];
    }
}
