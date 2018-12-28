<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', HiddenType::class, [
                'attr' => ['class'=> 'js-country']
            ])
            ->add('region', HiddenType::class, [
                'attr' => ['class'=> 'js-region']
            ])
            ->add('department', HiddenType::class, [
                'attr' => ['class'=> 'js-department']
            ])
            ->add('address', TextType::class, [
                'attr' => ['class'=> 'js-address']
            ])
            ->add('city', TextType::class, [
                'attr' => ['class'=> 'js-city']
            ])
            ->add('postCode', HiddenType::class, [
                'attr' => ['class'=> 'js-postcode']
            ])
            ->add('longitude', HiddenType::class, [
                'attr' => ['class'=> 'js-lng']
            ])
            ->add('latitude', HiddenType::class, [
                'attr' => ['class'=> 'js-lat']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
