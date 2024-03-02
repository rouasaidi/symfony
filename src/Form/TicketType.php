<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $event = $options['event'];
        
        $builder
            ->add('eventNom', TextType::class, [
                'data' => $event->getNom(),
                'mapped' => false,
                'disabled' => true,
            ])
            ->add('eventLieu', TextType::class, [
                'data' => $event->getLieu(),
                'mapped' => false,
                'disabled' => true,
            ])
            ->add('eventDate', TextType::class, [
                'data' => $event->getDateEvent() ? $event->getDateEvent()->format('Y-m-d') : null,
                'mapped' => false,
                'disabled' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'VIP' => 'VIP',
                    'Standard' => ' standard',
                ],
                'placeholder' => 'Select a type',
                'required' => true,
            ])

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                
                $typeOptions = [
                    'choices' => [
                        'VIP' => 'VIP',
                        'Standard' => 'Standard',
                    ],
                    'placeholder' => 'Select a type',
                    'required' => true,
                ];
            
                if ($data instanceof Ticket) {
                    if ($data->getType() === 'VIP') {
                        $price = 35;
                    } elseif ($data->getType() === 'Standard') {
                        $price = 20;
                    } else {
                        $price = null; // Set a default value if neither 'VIP' nor 'Standard'
                    }
                } else {
                    $price = null; // Set a default value if $data is not an instance of Ticket
                }
            
                $form
                    ->add('type', ChoiceType::class, $typeOptions)
                    ->add('price', NumberType::class, [
                        'data' => $price,
                        'required' => true,
                        'disabled' => true,
                    ]);
            })
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
        $resolver->setRequired('event'); // Requires the 'event' option to be set
    }
}