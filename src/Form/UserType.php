<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Validator\UniqUsername;
use App\Form\UserPhotoType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
              'translation_domain' => false,

            ))
            ->add('password', PasswordType::class, array(
              'translation_domain' => false,
            ))
            ->add('email', EmailType::class, array(
              'translation_domain' => false,
            ))
            ->add('userPhoto', UserPhotoType::class, array(
              'translation_domain' => false,
              ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
