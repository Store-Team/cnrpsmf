<?php

namespace App\Controller\Admin;

use App\Entity\SurveillanceChargement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class SurveillanceChargementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SurveillanceChargement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Surveillance Chargement')
            ->setEntityLabelInPlural('Surveillances Chargement')
            ->setPageTitle('index', 'Gestion des Surveillances de Chargement')
            ->setSearchFields(['matricule', 'numero_recu', 'r_organisation', 'v_matricule'])
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
            TextField::new('r_organisation', 'Organisation'),
            TextField::new('r_nationalite', 'Nationalité'),
            TextField::new('r_addresse', 'Adresse'),
            TelephoneField::new('r_telephone', 'Téléphone'),
            TextField::new('v_matricule', 'Matricule véhicule'),
            TextField::new('type_charge', 'Type charge'),
            TextField::new('tonnage_kg', 'Tonnage (kg)'),
            BooleanField::new('signalisation', 'Signalisation'),
            BooleanField::new('couverture', 'Couverture'),
            TextField::new('p_depart', 'Point départ'),
            TextField::new('p_arrivee', 'Point arrivée'),
            TimeField::new('h_depart', 'Heure départ'),
            TimeField::new('h_arrivee', 'Heure arrivée'),
            TextField::new('nom_inspecteur', 'Nom inspecteur'),
            BooleanField::new('approuvee', 'Approuvée'),
        ];
    }
}