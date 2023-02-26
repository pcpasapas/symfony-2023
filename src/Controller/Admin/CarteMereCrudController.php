<?php

namespace App\Controller\Admin;

use App\Entity\CarteMere;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarteMereCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarteMere::class;
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
