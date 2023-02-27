<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PagesController extends AbstractController
{
    #[Route('/', name: 'homepage', schemes:"https")]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('accueil/index.html.twig', ['_fragment' => "index", 'last_username' => $lastUsername, 'error' => $error]);
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