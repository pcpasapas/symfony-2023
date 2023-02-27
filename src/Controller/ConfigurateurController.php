<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Boitier;
use App\Entity\Category;
use App\Models\Categorie;
use App\Repository\PanierRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class ConfigurateurController extends AbstractController
{
    private $categories;

    public function __construct(private CategoryRepository $categoryRepository, private PanierRepository $panierRepository, private RequestStack $requestStack)
    {
        $this->categories = $categoryRepository->findAll();
    }

    public function getSomme($panier): string {
        $somme = 0;
        foreach ($panier as $item) {
            if ($item != null) {
                $somme += $item->getPrice();
            }
        }
        return number_format($somme/100, 2, ',', ' ') .  '€';;
    }

    #[Route('/configurateur/new', name: 'configurateur.new')]
    public function new(PanierRepository $panierRepository, Request $request): Response
    {
        // creation du nouveau panier
        $panier = new Panier();
        if ($this->getUser()) {
            $panier->setUser($this->getUser());
        }
        $panierRepository->save($panier, true);
        // stockage dans la session

        $session = $request->getSession();
        $session->set('panier', $panier->getId());


        $panier = $this->panierRepository->getPanierInArray($session->get('panier'));
        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => null,
            'panier' => $panier,
            'somme' => $this->getSomme($panier)
        ]);
    }



    #[Route('/configurateur', name: 'configurateur')]
    public function index(Request $request): Response
    {
        // stockage du panier dans la session
        $session = $request->getSession();
        if ($request->get('panier')) {
            $session->set('panier', $request->get('panier'));
        }
        $panier = $this->panierRepository->getPanierInArray($session->get('panier'));
        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => null,
            'panier' => $panier,
            'somme' => $this->getSomme($panier)
        ]);
    }
    
    #[Route('/configurateur/add/{slug}/{id}', name: 'addCart')]
    public function addCart(string $slug, $id, ManagerRegistry $doctrine, Request $request): Response
    {
        $categorie = $doctrine->getRepository(Category::class)->findOneBy(array('slug' => $slug));
        $em = $doctrine->getManager();
        $class = "App\\Entity\\" . $categorie->getSlug();
        $composant = $doctrine->getRepository($class)->find($id);
        $session = $request->getSession();
        $panier = $doctrine->getRepository(Panier::class)->find($session->get('panier'));


        $methode = "set" . $categorie->getSlug();   
        $panier->$methode($composant);
        $em->flush();

        return $this->redirectToRoute('configurateur');
    }

    #[Route('/configurateur/remove/{categorie}', name: 'removeCart')]
    public function removeCart(string $categorie, ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $session = $request->getSession();

        $panier = $doctrine->getRepository(Panier::class)->find($session->get('panier'));
        $methode = "set" . $categorie;
        $panier->$methode(null);
        $em->flush();
        return $this->redirectToRoute('configurateur');
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

        $session = $this->requestStack->getSession();

        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => $composants,
            'panier' => $this->panierRepository->getPanierInArray($session->get('panier')),
            'somme' => $this->getSomme($this->panierRepository->getPanierInArray($session->get('panier')))
        ]);
    }


}