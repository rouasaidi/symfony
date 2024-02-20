<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'The name field cannot be empty.',
                ]),
               /* new Assert\NotNull([
                    'message' => 'Le champ nom ne peut pas être vide.',
                ]),*/
                new Length([
                    'min' => 5,
                    'max' => 255,
                    'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        //->add('name')
           // ->add('email')
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
            'invalid_message' => 'L\'adresse email est invalide.', // Message d'erreur personnalisé
        ])
           //->add('password')
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
            ])
            //->add('phone')
            ->add('phone', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The name field cannot be empty.',
                    ]),
                    new Length([
                        'max' => 8,
                        'min' => 8,
                        'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                      
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\d+$/', // Accepte uniquement les nombres positifs
                        'message' => 'The telephone number must contain only positive digits.',
                    ]),
                ],
                'invalid_message' => 'Le numéro de téléphone est invalide.', // Message d'erreur personnalisé
            ])
            
           // ->add('cin')
           ->add('cin', IntegerType::class, [
            'constraints' => [
                new NotBlank([
                
                ]),
                new Length([
                    'max' => 8,
                    'min' => 8,
                    'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                  
                ]),
                new Assert\Regex([
                    'pattern' => '/^\d+$/', // Accepte uniquement les nombres positifs
                    'message' => 'The telephone number must contain only positive digits.',
                ]),
            ],
            'invalid_message' => 'Le numéro de téléphone est invalide.', // Message d'erreur personnalisé
        ])
            ->add('image', UrlType::class, [
        
       
                'label' => 'Image '
                    ])
            
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Product' => 'Product',
                    'Donnation' => 'Donnation',
                    'Panier' => 'Panier',
                    'Blog' => 'Blog',
                    'event' => 'event',
                    
                    
                ],
            ])
              //  ->add('save',submitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}