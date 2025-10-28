<?php

namespace App\Controller\Admin;

use App\Entity\SurveillanceTaxiMoto;
use App\Entity\InspectionConvoi;
use App\Entity\SurveillanceChargement;
use App\Entity\Quittance;
use App\Entity\AutorisationConvoiExceptionel;
use App\Entity\AutorisationMateriauxConstruction;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function index(): Response
    {
        // Récupérer les statistiques des enregistrements
        $stats = [
            'surveillanceTaxiMoto' => $this->entityManager->getRepository(SurveillanceTaxiMoto::class)->count([]),
            'inspectionConvoi' => $this->entityManager->getRepository(InspectionConvoi::class)->count([]),
            'surveillanceChargement' => $this->entityManager->getRepository(SurveillanceChargement::class)->count([]),
            'quittance' => $this->entityManager->getRepository(Quittance::class)->count([]),
            'autorisationConvoiExceptionel' => $this->entityManager->getRepository(AutorisationConvoiExceptionel::class)->count([]),
            'autorisationMateriauxConstruction' => $this->entityManager->getRepository(AutorisationMateriauxConstruction::class)->count([]),
        ];

        return $this->render('admin/dashboard.html.twig', [
            'stats' => $stats
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CNRP SMF -oAdministration')
            ->setFaviconPath('logo.jpg')
            ->setDefaultColorScheme('dark')
            ->renderSidebarMinimized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de Bord', 'fa fa-home');
        
        yield MenuItem::section('Surveillance & Contrôle');
        yield MenuItem::linkToCrud('Surveillance Taxi/Moto', 'fas fa-motorcycle', SurveillanceTaxiMoto::class);
        yield MenuItem::linkToCrud('Inspection Convoi', 'fas fa-truck', InspectionConvoi::class);
        yield MenuItem::linkToCrud('Surveillance Chargement', 'fas fa-boxes', SurveillanceChargement::class);
        
        yield MenuItem::section('Autorisations');
        yield MenuItem::linkToCrud('Convoi Exceptionnel', 'fas fa-exclamation-triangle', AutorisationConvoiExceptionel::class);
        yield MenuItem::linkToCrud('Matériaux Construction', 'fas fa-hammer', AutorisationMateriauxConstruction::class);
        
        yield MenuItem::section('Finance');
        yield MenuItem::linkToCrud('Quittances', 'fas fa-receipt', Quittance::class);
        
        yield MenuItem::section('API');
        yield MenuItem::linkToUrl('Documentation API', 'fas fa-book', '/api/doc');
    }
}
