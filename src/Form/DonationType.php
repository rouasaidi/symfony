<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Donation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DonationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Clothes' => 'Clothes',
                    'Toys' => 'Toys',
                    'School Supplies' => 'School Supplies',
                ],
            ])
            ->add('quantity')
            ->add('date_don')
            ->add('image')
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $donation = $event->getData();
                $form = $event->getForm();
    
                // Si la commande est nouvelle (c'est-à-dire qu'elle n'a pas encore de date de validation)
                if (!$donation || null === $donation->getId()) {
                    // Remplir la date de validation avec la date actuelle
                    if (null === $donation->getDateDon()) {
                       $donation->setDateDon(new \DateTime());
                    }
                    $form->add('date_don', null, ['disabled' => true]); // Désactiver le champ pour l'afficher sans possibilité de modification
                }
                else {
                    // Pour les éditions, supprimez simplement le champ date_don du formulaire
                    $form->remove('date_don');
                }
            });
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
