<?php

namespace App\Controller\Admin;

use App\Entity\SurveillanceTaxiMoto;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class SurveillanceTaxiMotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SurveillanceTaxiMoto::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Surveillance Taxi/Moto')
            ->setEntityLabelInPlural('Surveillances Taxi/Moto')
            ->setPageTitle('index', 'Gestion des Surveillances Taxi/Moto')
            ->setSearchFields(['matricule', 'nom_dem', 'corporation', 'm_matricule', 'marque_moto'])
            ->setDefaultSort(['date_emission' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('matricule', 'Matricule'),
            TextField::new('numero_recu', 'N° Reçu'),
            TextField::new('lieu_emission', 'Lieu d\'émission'),
            DateField::new('date_emission', 'Date d\'émission'),
            TextField::new('nom_dem', 'Nom demandeur'),
            TextField::new('corporation', 'Corporation/Syndicat'),
            TelephoneField::new('telephone_dem', 'Téléphone'),
            TextField::new('m_matricule', 'Matricule véhicule'),
            TextField::new('marque_moto', 'Marque moto'),
            TextField::new('inspecteur1', 'Inspecteur 1'),
            TextField::new('inspecteur2', 'Inspecteur 2'),
            TextField::new('inspecteur3', 'Inspecteur 3'),
        ];
    }
}