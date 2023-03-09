<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuxController extends AbstractController
{
    #[Route('/jeux', name: 'app_jeux')]
    public function index(Security $security, GameRepository $gameRepository): Response
    {
        $response = $security->logout(false);
        $jeux = $gameRepository->findAll();

        return $this->render('jeux/index.html.twig', [
            'jeux' => $jeux,
        ]);
    }

    #[Route('/jeux/{slug}', name: 'jeu.show')]
    public function show(PanierRepository $panierRepository, GameRepository $gameRepository, Game $game): Response
    {
        $panier = $panierRepository->getPanierInArray($game->getPanier()->getId());

        return $this->render('jeux/show.html.twig', [
            'jeu' => $game,
            'panier' => $panier,
            'somme' => $this->getSomme($panier),
        ]);
    }

    public function getSomme($panier): string
    {
        $somme = 0;
        foreach ($panier as $item) {
            if (null !== $item) {
                $somme += $item->getPrice();
            }
        }

        return number_format($somme / 100, 2, ',', ' ') . '€';
    }
}
