<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Webmozart\Assert\Assert as AssertAssert;

class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', PasswordType::class, [
            
            'constraints' => [
                new NotBlank([
                    'message' => 'The name field cannot be empty.',
                ]),
                new Length([
                    'min' => 8,
                    'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                  
                ]),
            ],
            'invalid_message' => 'Le mot de passe est invalide.', // Message d'erreur personnalisé
            'label' => 'Entrez votre mot de passe',
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}