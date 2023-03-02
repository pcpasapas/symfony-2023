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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
    public function new(PanierRepository $panierRepository, Request $request, AuthenticationUtils $authenticationUtils): Response
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

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => null,
            'panier' => $panier,
            'somme' => $this->getSomme($panier),
            'panierEntity' => $this->panierRepository->find($session->get('panier')),
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/configurateur', name: 'configurateur')]
    public function index(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // stockage du panier dans la session
        $session = $request->getSession();
        if ($request->get('panier')) {
            if (null != $this->panierRepository->find($request->get('panier'))) {
                if ($this->getUser() == $this->panierRepository->find($request->get('panier'))->getUser()) {
                    $session->set('panier', $request->get('panier'));
                } else {
                    $this->addFlash('danger', 'Panier inexistant');

                    return $this->redirectToRoute('app_login');
                }
            } else {
                $this->addFlash('danger', 'Panier inexistant');

                return $this->redirectToRoute('app_login');
            }
        }

        if ($session->get('panier')) {
            $panier = $this->panierRepository->getPanierInArray($session->get('panier'));
        } else {
            return $this->redirectToRoute('configurateur.new');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => null,
            'panier' => $panier,
            'panierEntity' => $this->panierRepository->find($session->get('panier')),
            'somme' => $this->getSomme($panier),
            'error' => $error,
            'last_username' => $lastUsername,
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
    public function categorie(Category $category, ManagerRegistry $doctrine, Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $class = 'App\\Entity\\'.$category->getSlug();
        $repo = $doctrine->getRepository($class);

        // recuperation du panier
        $session = $request->getSession();
        $panier = $doctrine->getRepository(Panier::class)->find($session->get('panier'));

        $composants = ('Processeur' == $category->getSlug() || 'CarteMere' == $category->getSlug()) ? $repo->findAllByPanier($panier) : $repo->findAll();

        $session = $this->requestStack->getSession();

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('configurateur/layout.html.twig', [
            'categories' => $this->categories,
            'composants' => $composants,
            'panier' => $this->panierRepository->getPanierInArray($session->get('panier')),
            'somme' => $this->getSomme($this->panierRepository->getPanierInArray($session->get('panier'))),
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }
}