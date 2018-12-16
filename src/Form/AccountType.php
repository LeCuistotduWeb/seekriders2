<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('surname')
            ->add('username')
            ->add('email')
            ->add('biography')
//            ->add('birthdayAt')
//            ->add('location', LocationType::class, [
//                // 'multiple' => true,
//                // 'expanded' => true,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
