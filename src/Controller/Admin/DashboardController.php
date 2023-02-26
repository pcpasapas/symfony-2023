<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CategoryCrudController;
use App\Entity\Alimentation;
use App\Entity\Boitier;
use App\Entity\CarteGraphique;
use App\Entity\CarteMere;
use App\Entity\Hdd;
use App\Entity\Panier;
use App\Entity\Processeur;
use App\Entity\Ram;
use App\Entity\Ssd;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;



class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {

    }
    #[Route('/admin', name: 'admin')]    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->adminUrlGenerator->setController(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CategoryCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pc pas à pas');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Retour au Site', 'fas fa-list', 'homepage');
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Boitiers', 'fas fa-list', Boitier::class);
        yield MenuItem::linkToCrud('Alimentations', 'fas fa-list', Alimentation::class);
        yield MenuItem::linkToCrud('Processeurs', 'fas fa-list', Processeur::class);
        yield MenuItem::linkToCrud('Cartes Mères', 'fas fa-list', CarteMere::class);
        yield MenuItem::linkToCrud('Cartes Graphiques', 'fas fa-list', CarteGraphique::class);
        yield MenuItem::linkToCrud('Ram', 'fas fa-list', Ram::class);
        yield MenuItem::linkToCrud('Hdd', 'fas fa-list', Hdd::class);
        yield MenuItem::linkToCrud('Ssd', 'fas fa-list', Ssd::class);
        yield MenuItem::linkToCrud('Paniers', 'fas fa-list', Panier::class);
    }
}