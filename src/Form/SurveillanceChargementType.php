<?php

namespace App\Form;

use App\Entity\SurveillanceChargement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveillanceChargementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('numero_recu')
            ->add('lieu_emission')
            ->add('date_emission')
            ->add('r_organisation')
            ->add('r_nationalite')
            ->add('r_addresse')
            ->add('r_telephone')
            ->add('v_matricule')
            ->add('type_charge')
            ->add('tonnage_kg')
            ->add('signalisation')
            ->add('couverture')
            ->add('p_depart')
            ->add('p_arrivee')
            ->add('h_depart')
            ->add('h_arrivee')
            ->add('nom_inspecteur')
            ->add('approuvee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SurveillanceChargement::class,
        ]);
    }
}
