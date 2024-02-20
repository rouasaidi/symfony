<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Panier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('total_price')
            ->add('total_quant')
            ->add('date_validation')
            ->add('panier', EntityType::class, [
                'class' => Panier::class,
                'choice_label' => 'id',
            ])
            ->add('user');

        // Événement pour remplir automatiquement la date de validation avec la date actuelle
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $commande = $event->getData();
            $form = $event->getForm();

            // Si la commande est nouvelle (c'est-à-dire qu'elle n'a pas encore de date de validation)
            if (!$commande || null === $commande->getId()) {
                // Remplir la date de validation avec la date actuelle
                $commande->setDateValidation(new \DateTime());
                $form->add('date_validation', null, ['disabled' => true]); // Désactiver le champ pour l'afficher sans possibilité de modification
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
