<?php

namespace App\Form;

use App\Entity\Quittance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuittanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('type_quittance')
            ->add('lieu_emission')
            ->add('date_emmision')
            ->add('assujettif')
            ->add('numero_perception')
            ->add('montant_chiffres')
            ->add('montant')
            ->add('banque')
            ->add('numero_compte')
            ->add('mode_payement')
            ->add('nature_impo')
            ->add('receveur_drlu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quittance::class,
        ]);
    }
}
