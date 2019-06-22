<?php

namespace App\Form;

use App\Entity\SessionSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDateAt', DateType::class, [
                'required' => false,
                'label' => "Début",
            ])
            ->add('endDateAt', DateType::class, [
                'required' => false,
                'label' => "Fin",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SessionSearch::class,
        ]);
    }
}
