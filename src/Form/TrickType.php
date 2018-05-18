<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\TrickPhotoType;
use App\Form\VideoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trickPhotos', CollectionType::class, array(
                  'translation_domain' => false,
                  'entry_type'   => TrickPhotoType::class,
                  'allow_add'    => true,
                  'allow_delete' => true
            ))
            ->add('videos', CollectionType::class, array(
                  'entry_type'   => VideoType::class,
                  'allow_add'    => true,
                  'allow_delete' => true,
                  'translation_domain' => false,
            ))
            ->add('name', TextType::class, array('translation_domain' => false))
            ->add('description', TextareaType::class, array('translation_domain' => false))
            ->add('trickGroup', EntityType::class, array(
              'class' => TrickGroup::class,
              'choice_label' => 'name',
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
