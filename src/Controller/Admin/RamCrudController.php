<?php

namespace App\Controller\Admin;

use App\Entity\Ram;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ram::class;
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
