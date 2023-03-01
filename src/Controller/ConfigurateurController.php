<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Panier;
use App\Repository\CategoryRepository;
use App\Repository\PanierRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigurateurController extends AbstractController
{
    private $categories;

    public function __construct(CategoryRepository $categoryRepository, private PanierRepository $panierRepository, private RequestStack $requestStack)
    {
        $this->categories = $categoryRepository->findAll();
    }

    #[Route('/saveCart', name: 'save.cart', methods: 'POST')]
    public function saveCart(Request $request, ManagerRegistry $doctrine): Response
    {
        $session = $request->getSession();
        $panierRepository = $doctrine->getRepository(Panier::class);
        $panier = $panierRepository->find($session->get('panier'));
        $panier->setName($request->get('name'));
        $panierRepository->save($panier, true);

        return $this->redirectToRoute('configurateur');
    }

    public function getSomme($panier): string
    {
        $somme = 0;
        foreach ($panier as $item) {
            if (null !== $item) {
                $somme += $item->getPrice();
            }
        }

        return number_format($somme / 100, 2, ',', ' ').'€';
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
            'somme' => $this->getSomme($panier),
            'panierEntity' => $this->panierRepository->find($session->get('panier')),
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
        if ($session->get('panier')) {
            $panier = $this->panierRepository->getPanierInArray($session->get('panier'));
        } else {
            return $this->redirectToRoute('configurateur.new');
        }

        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => null,
            'panier' => $panier,
            'panierEntity' => $this->panierRepository->find($session->get('panier')),
            'somme' => $this->getSomme($panier),
        ]);
    }

    #[Route('/configurateur/add/{slug}/{id}', name: 'addCart')]
    public function addCart(string $slug, $id, ManagerRegistry $doctrine, Request $request): Response
    {
        $categorie = $doctrine->getRepository(Category::class)->findOneBy(['slug' => $slug]);
        $em = $doctrine->getManager();
        $class = 'App\\Entity\\'.$categorie->getSlug();
        $composant = $doctrine->getRepository($class)->find($id);
        $session = $request->getSession();
        $panier = $doctrine->getRepository(Panier::class)->find($session->get('panier'));

        $methode = 'set'.$categorie->getSlug();
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
        $methode = 'set'.$categorie;
        $panier->$methode(null);
        $em->flush();

        return $this->redirectToRoute('configurateur');
    }

    #[Route('/configurateur/{slug}', name: 'configurateur.cat')]
    /**
     * retourne la page configurateur avec les comoposants de la category.
     */
    public function categorie(Category $category, ManagerRegistry $doctrine, Request $request): Response
    {
        $class = 'App\\Entity\\'.$category->getSlug();
        $repo = $doctrine->getRepository($class);

        // recuperation du panier
        $session = $request->getSession();
        $panier = $doctrine->getRepository(Panier::class)->find($session->get('panier'));

        if ('Processeur' == $category->getSlug() || 'CarteMere' == $category->getSlug()) {
            $composants = $repo->findAllByPanier($panier);
        } else {
            $composants = $repo->findAll();
        }

        $session = $this->requestStack->getSession();

        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => $composants,
            'panier' => $this->panierRepository->getPanierInArray($session->get('panier')),
            'somme' => $this->getSomme($this->panierRepository->getPanierInArray($session->get('panier'))),
        ]);
    }
}
