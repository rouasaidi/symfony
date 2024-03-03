<?php

namespace App\Form;

use App\Entity\FeedbackDon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FeedbackDonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('date_feedback')
            ->add('donation')
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $feedbackDon = $event->getData();
                $form = $event->getForm();
    
                // Si la commande est nouvelle (c'est-à-dire qu'elle n'a pas encore de date de validation)
                if (!$feedbackDon || null === $feedbackDon->getId()) {
                    // Remplir la date de validation avec la date actuelle
                    $feedbackDon->setDateFeedback(new \DateTime());
                    $form->add('date_feedback', null, ['disabled' => true]); // Désactiver le champ pour l'afficher sans possibilité de modification
                }
                else {
                    // Pour les éditions, supprimez simplement le champ date_don du formulaire
                    $form->remove('date_feedback');
                }
            });
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeedbackDon::class,
        ]);
    }
}
