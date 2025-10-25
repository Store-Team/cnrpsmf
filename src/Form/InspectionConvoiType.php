<?php

namespace App\Form;

use App\Entity\InspectionConvoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InspectionConvoiType extends AbstractType
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
            ->add('longueur')
            ->add('v_largeur')
            ->add('hauteur')
            ->add('arrimage')
            ->add('centrage')
            ->add('signalisation')
            ->add('p_depart')
            ->add('p_arrivee')
            ->add('h_depart')
            ->add('h_arrivee')
            ->add('raison_arret')
            ->add('observations_generales')
            ->add('approuve')
            ->add('inspecteur_nom')
            ->add('equipe1')
            ->add('equipe1_contact')
            ->add('equipe2')
            ->add('equipe2_contact')
            ->add('equipe3')
            ->add('euipe3_contact')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InspectionConvoi::class,
        ]);
    }
}
