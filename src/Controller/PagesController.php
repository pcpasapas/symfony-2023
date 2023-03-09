<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PagesController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(AuthenticationUtils $authenticationUtils, PanierRepository $panierRepository, GameRepository $gameRepository): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        $panierUser = $panierRepository->findByUser($this->getUser());
        $games = $gameRepository->findAll();

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('accueil/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'panierUser' => $panierUser,
            'games' => $games,
        ]);
    }

    #[Route('/tutos', name: 'tuto_pages')]
    public function tutos(): Response
    {
        return $this->render('pages/tutos.html.twig');
    }

    #[Route('/composants', name: 'composants.index')]
    public function composants(): Response
    {
        return $this->render('composants/index.html.twig');
    }

    #[Route('/jeux', name: 'jeux_pages')]
    public function jeux(): Response
    {
        return $this->render('pages/jeux.html.twig');
    }
}
