<?php

namespace App\Form;

use App\Entity\AutorisationMateriauxConstruction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutorisationMateriauxConstructionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('lieu_emission')
            ->add('date_emission')
            ->add('r_type')
            ->add('r_nationalite')
            ->add('r_addresse')
            ->add('r_telephone')
            ->add('v_matricule')
            ->add('v_marque')
            ->add('v_type')
            ->add('type_charge')
            ->add('tonnage_kg')
            ->add('r_securite')
            ->add('heure_circulation')
            ->add('p_depart')
            ->add('p_arrivee')
            ->add('h_depart')
            ->add('h_arrivee')
            ->add('arrimage')
            ->add('centrage')
            ->add('signalisation')
            ->add('charge_technique')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AutorisationMateriauxConstruction::class,
        ]);
    }
}
