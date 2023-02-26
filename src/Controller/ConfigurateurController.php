<?php

namespace App\Controller;

use App\Entity\Boitier;
use App\Entity\Category;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConfigurateurController extends AbstractController
{
    private $categories;
    public function __construct(private CategoryRepository $categoryRepository)
    {

        $this->categories = $categoryRepository->findAll();
    }
    #[Route('/configurateur', name: 'configurateur')]
    public function index(): Response
    {
        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => null
        ]);
    }
    
    #[Route('/configurateur/add/{name}/{id}', name: 'addCart')]
    public function addCart(Category $categorie, $id, ManagerRegistry $doctrine): Response
    {
        $class = "App\\Entity\\" . $categorie->getSlug();
        $composant = $doctrine->getRepository($class)->find($id);
        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => null
        ]);
    }

    #[Route('/configurateur/{slug}', name: 'configurateur.cat')]
    /**
     * retourne la page configurateur avec les comoposants de la category
     * @param Category $category
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function categorie(Category $category, ManagerRegistry $doctrine): Response
    {
        $class = "App\\Entity\\" . $category->getSlug();
        $repo = $doctrine->getRepository($class);
        $composants = $repo->findAll();
        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => $composants
        ]);
    }


}