<?php

namespace App\Controller\Admin;

use App\Entity\InspectionConvoi;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class InspectionConvoiCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InspectionConvoi::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Inspection Convoi')
            ->setEntityLabelInPlural('Inspections Convoi')
            ->setPageTitle('index', 'Gestion des Inspections de Convoi')
            ->setSearchFields(['matricule', 'v_matricule', 'v_marque', 'inspecteur_nom'])
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
            BooleanField::new('arrimage', 'Arrimage OK'),
            BooleanField::new('centrage', 'Centrage OK'),
            BooleanField::new('signalisation', 'Signalisation OK'),
            TextField::new('p_depart', 'Point départ'),
            TextField::new('p_arrivee', 'Point arrivée'),
            TimeField::new('h_depart', 'Heure départ'),
            TimeField::new('h_arrivee', 'Heure arrivée'),
            TextareaField::new('raison_arret', 'Raison arrêt')->hideOnIndex(),
            TextareaField::new('observations_generales', 'Observations')->hideOnIndex(),
            BooleanField::new('approuve', 'Approuvé'),
            TextField::new('inspecteur_nom', 'Inspecteur'),
            TextField::new('equipe1', 'Équipe 1'),
            TelephoneField::new('equipe1_contact', 'Contact équipe 1')->hideOnIndex(),
            TextField::new('equipe2', 'Équipe 2'),
            TelephoneField::new('equipe2_contact', 'Contact équipe 2')->hideOnIndex(),
            TextField::new('equipe3', 'Équipe 3'),
            TelephoneField::new('equipe3_contact', 'Contact équipe 3')->hideOnIndex(),
        ];
    }
}