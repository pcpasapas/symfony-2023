<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Boitier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BoitierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Boitier::class;
    }

    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         AssociationField::new('category')
    //             ->setCrudController(CategoryCrudController::class),
    //         TextField::new('name'),
    //         TextField::new('modele'),
    //         IntegerField::new('price')
    //     ];

    // }
}
