<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Ssd;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SsdCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ssd::class;
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
