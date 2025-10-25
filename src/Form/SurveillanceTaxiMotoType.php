<?php

namespace App\Form;

use App\Entity\SurveillanceTaxiMoto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveillanceTaxiMotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('numero_recu')
            ->add('lieu_emission')
            ->add('date_emission')
            ->add('nom_dem')
            ->add('corporation')
            ->add('telephone_dem')
            ->add('m_matricule')
            ->add('marque_moto')
            ->add('inspecteur1')
            ->add('inspecteur2')
            ->add('inspecteur3')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SurveillanceTaxiMoto::class,
        ]);
    }
}
