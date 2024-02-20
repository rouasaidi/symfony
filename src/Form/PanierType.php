<?php

namespace App\Form;

use App\Entity\Panier;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('total_price')
            ->add('total_quant', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'inputmode' => 'numeric',
                    'step' => '1', // Step by 1
                    'min' => '0',  // Minimum value
                ],
            ])            // ->add('status')
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'name', // Assuming 'name' is the property you want to display
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Panier::class,
        ]);
    }
}
