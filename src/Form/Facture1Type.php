<?php

namespace App\Form;

use App\Entity\Facture;
use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class Facture1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('imageF',FileType::class,[
                'required' => false,
                'mapped' => false,
            ])

        ->add('libelle')
            ->add('date', DateTimeType::class,[
                'disabled' => false,
                'widget' => 'single_text',
            ])
            ->add('dateEch', DateTimeType::class,[
                'disabled' => false,
                'widget' => 'single_text',
            ])
            ->add('montant')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'EAU' => 'EAU',
                    'ENERGY' => 'ENERGY',
                    
                ]])
            //->add('estPayee')
            ->add('estPayee', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true, // Rend les boutons radio au lieu d'une liste déroulante
                'multiple' => false, // Permet à l'utilisateur de sélectionner une seule option
                'label' => 'Payée ?', // Libellé du champ
            ])
            ->remove('idUser')
            ->add('Ajouter', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-primary']

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
