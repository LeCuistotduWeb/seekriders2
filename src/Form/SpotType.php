<?php

namespace App\Form;

use App\Entity\Spot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [])
            ->add('description', TextareaType::class, [])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Skatepark' => 'skatepark',
                    'Street' => 'street',
                ]
            ])
            ->add('paying', ChoiceType::class, [
                'choices'  => [
                    'Nc' => null,
                    'Gratuit' => 'free',
                    'Payant' => 'paid',
                ]
            ])
            ->add('Location', LocationType::class, [])
//            ->add('createdAt')
//            ->add('author')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
