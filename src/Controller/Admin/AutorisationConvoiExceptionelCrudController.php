<?php

namespace App\Controller\Admin;

use App\Entity\AutorisationConvoiExceptionel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class AutorisationConvoiExceptionelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AutorisationConvoiExceptionel::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Autorisation Convoi Exceptionnel')
            ->setEntityLabelInPlural('Autorisations Convoi Exceptionnel')
            ->setPageTitle('index', 'Gestion des Autorisations de Convoi Exceptionnel')
            ->setSearchFields(['matricule', 'v_matricule', 'v_marque', 'r_addresse'])
            ->setDefaultSort(['date_emission' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('matricule', 'Matricule'),
            TextField::new('lieu_emission', 'Lieu d\'émission'),
            DateField::new('date_emission', 'Date d\'émission'),
            TextField::new('r_type', 'Type responsable'),
            TextField::new('r_nationalite', 'Nationalité'),
            TextField::new('r_addresse', 'Adresse'),
            TelephoneField::new('r_telephone', 'Téléphone'),
            TextField::new('v_matricule', 'Matricule véhicule'),
            TextField::new('v_marque', 'Marque véhicule'),
            TextField::new('v_type', 'Type véhicule'),
            TextField::new('type_charge', 'Type charge'),
            TextField::new('tonnage_kg', 'Tonnage (kg)'),
            TextField::new('longueur', 'Longueur (m)'),
            TextField::new('v_largeur', 'Largeur (m)'),
            TextField::new('hauteur', 'Hauteur (m)'),
            TextField::new('r_securite', 'Mesures sécurité'),
            TextField::new('heure_circulation', 'Heures circulation'),
            TextField::new('p_depart', 'Point départ'),
            TextField::new('p_arrivee', 'Point arrivée'),
            TimeField::new('h_depart', 'Heure départ'),
            TimeField::new('h_arrivee', 'Heure arrivée'),
            BooleanField::new('arrimage', 'Arrimage'),
            BooleanField::new('centrage', 'Centrage'),
            BooleanField::new('signalisation', 'Signalisation'),
            TextareaField::new('charge_technique', 'Caractéristiques techniques')->hideOnIndex(),
        ];
    }
}