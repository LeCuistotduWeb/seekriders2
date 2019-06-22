<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Spot;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre de la session"
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description de la session",
                'required' => false,
            ])
            ->add('startDateAt', DateTimeType::class, [
                'label' => "Début de la session"
            ])
            ->add('endDateAt', DateTimeType::class, [
                'label' => "Fin de la session"
            ])
            ->add('isContest', CheckboxType::class, [
                'label' => " Cette session est une compétition ?",
                'required' => false,
            ])
            ->add('spot', EntityType::class, [
                'label' => 'Nom du spot',
                'class' => Spot::class,
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
