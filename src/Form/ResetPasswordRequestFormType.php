<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as AssertAssert;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'The name field cannot be empty.',
                ]),
                
                new Assert\Regex([
                    'pattern' => '/@/', // Vérifie si l'adresse e-mail contient le symbole "@"
                    'message' => 'L\'adresse email doit contenir le symbole "@".',
                ]),
            ],
            'invalid_message' => 'L\'adresse email est invalide.', // Message d'erreur personnalisé  'label' => 'Entrez votre mot de passe',
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
