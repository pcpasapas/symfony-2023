<?php

namespace App\Controller\Admin;

use App\Entity\Processeur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProcesseurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Processeur::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
