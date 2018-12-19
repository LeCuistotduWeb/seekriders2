<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [])
            ->add('surname', TextType::class, [])
            ->add('username', TextType::class, [])
            ->add('email', EmailType::class, [])
            ->add('biography', TextareaType::class, [])
            ->add('birthdayAt', DateType::class, [
                'widget' => 'single_text',
//                'html5'  => false,
                'attr'   => ['class' => 'js-datepicker'],
            ])
            ->add('location', LocationType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
