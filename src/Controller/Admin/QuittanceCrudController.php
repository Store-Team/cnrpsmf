<?php

namespace App\Controller\Admin;

use App\Entity\Quittance;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class QuittanceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quittance::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Quittance')
            ->setEntityLabelInPlural('Quittances')
            ->setPageTitle('index', 'Gestion des Quittances')
            ->setSearchFields(['matricule', 'assujettif', 'numero_perception', 'banque'])
            ->setDefaultSort(['date_emmision' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('matricule', 'Matricule'),
            TextField::new('type_quittance', 'Type quittance'),
            TextField::new('lieu_emission', 'Lieu d\'émission'),
            DateField::new('date_emmision', 'Date d\'émission'),
            TextField::new('assujettif', 'Assujetti'),
            TextField::new('numero_perception', 'N° Perception'),
            TextField::new('montant_chiffres', 'Montant (chiffres)'),
            MoneyField::new('montant', 'Montant')
                ->setCurrency('XAF')
                ->setStoredAsCents(false),
            TextField::new('banque', 'Banque'),
            TextField::new('numero_compte', 'N° Compte'),
            TextField::new('mode_payement', 'Mode paiement'),
            TextField::new('nature_impo', 'Nature impôt'),
            TextField::new('receveur_drlu', 'Receveur DRLU'),
        ];
    }
}