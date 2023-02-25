<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('pages/index.html.twig');
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
