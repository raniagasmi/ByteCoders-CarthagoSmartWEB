<?php

namespace App\Form;

use App\Entity\Typedechets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Validator\Constraints\NotBlank;

class TypedechetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('name' ,TextType::class, [
                'required' => true, // Assurez-vous que ce champ est requis
            ])

            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Recyclable' => 'RECYCLABLE',
                    'Non recyclable' => 'NON_RECYCLABLE',
                ],
                'placeholder' => 'Choisir la categorie', // Optionnel

                
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Typedechets::class,
        ]);
    }
}
