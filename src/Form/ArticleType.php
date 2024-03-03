<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType
use App\Entity\User; // Import the User entity
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('date', TextType::class, [
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            ->add('user', EntityType::class, [ // Add the user field
                'class' => User::class,
                'choice_label' => 'name', // Assuming 'name' is the property in the User entity to display
                'attr' => ['class' => 'form-control'],
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image (JPG or PNG)',
                'required' => true,
                'allow_delete' => true,
                'download_uri' => false,

            ])
          
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
