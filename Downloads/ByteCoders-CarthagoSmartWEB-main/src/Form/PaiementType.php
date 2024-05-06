<?php

namespace App\Form;

use App\Entity\Paiement;
use App\Entity\Facture;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardNumber', TextType::class, [
                'mapped' => false, // not mapped to entity property
                'label' => 'Numéro de carte',
                'required' => true,
                'attr' => ['placeholder' => 'Numéro de carte'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le numéro de carte']),
                    new Length([
                        'min' => 16,
                        'max' => 16,
                        'minMessage' => 'Le numéro de la carte doit comporter {{ limit }} chiffres',
                        'maxMessage' => 'Le numéro de la carte doit comporter {{ limit }} chiffres',]),
                    new Type(['type' => 'numeric',
                        'message' => 'Le numéro de la carte doit être composé uniquement de chiffres',])
                ]])
            ->add('cardExpiry', DateType::class, [
                'mapped' => false,
                'label' => 'Expiration (MM/YY)',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'MM/yy',
                'attr' => [
                    'placeholder' => 'MM/YY',
                    'class' => 'form-control',
                ],
            ])
            ->add('cardCVC', TextType::class, [
                'mapped' => false, // not mapped to entity property
                'label' => 'CVC',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le numéro de carte']),
                    new Regex([
                        'pattern' => '/^\d{3,4}$/',
                        'message' => 'CVC doit comporter de 3 à 4 chiffres.',
                    ]),
                ],
            ])
            ->add('cardholderName', TextType::class, [
                'mapped' => false, // not mapped to entity property
                'label' => 'Cardholder Name'
            ])
            //->add('country', CountryType::class, ['label' => 'Country or Region'])
            //->add('saveInformation', CheckboxType::class, [
            //    'mapped' => false, // not mapped to entity property
            //    'label' => 'Save this information for next time'
            //])
            ->add('submit', SubmitType::class, [
                'label' => 'Payer',
                'attr' => [
                    'class' => 'btn btn-primary w-100 custom-gradient-btn']
            ])


            //->add('idFacture', EntityType::class, [
            //    'class' => Facture::class,
            //    'choice_label' => 'montant',
            //    'label' => 'Montant facture'])

            //->remove('montant')
            //->remove('mode_paiement')
            //->add('idFacture', EntityType::class, [
            //    'class' => Facture::class,
            //    'choice_label' => 'idFacture', // Adjust as per your Facture entity
            //    'label' => 'Réference facture'
            //])
            //->add('id', EntityType::class, [
            //    'class' => User::class,
            //    'choice_label' => 'id', // Adjust as per your User entity
            //    'label' => 'Utilisateur'
            //])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
