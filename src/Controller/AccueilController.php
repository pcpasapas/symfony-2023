<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/removeUserCart', 'removeUserCart', methods:['POST'])]
    public function removeUserCart(PanierRepository $panierRepository, Request $request)
    {
        $panier = $panierRepository->find($request->get('panier'));
        $panierRepository->remove($panier, true);
        return $this->redirectToRoute('homepage');
    }
}
