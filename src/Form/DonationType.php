<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\Donation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'vetemants' => 'vetaments',
                    'jouet' => 'jouets',
                    'fournitures scolaires' => 'fournitures scolaires',
                ],
            ])
            ->add('quantity')
            ->add('date_don')
            ->add('status')
            ->add('image')
            ->add('user')
            ->add('panier')
            
            ;
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
