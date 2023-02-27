<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PagesController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(AuthenticationUtils $authenticationUtils, PanierRepository $panierRepository): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        $panierUser = $panierRepository->findByUser($this->getUser());
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('accueil/index.html.twig', ['_fragment' => 'index', 'last_username' => $lastUsername, 'error' => $error, 'panierUser' => $panierUser]);
    }

    #[Route('/tutos', name: 'tuto_pages')]
    public function tutos(): Response
    {
        return $this->render('pages/tutos.html.twig');
    }
    #[Route('/jeux', name: 'jeux_pages')]
    public function jeux(): Response
    {
        return $this->render('pages/jeux.html.twig');
    }
}
