<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => false,
            ])
            ->add('surname', TextType::class, [
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'required' => false,
            ])
            ->add('email', EmailType::class, [])
            ->add('biography', TextareaType::class, ['required' => false,])
            ->add('level', ChoiceType::class, [
                'choices' => $this->getChoices(User::USER_LEVEL),
            ])
            ->add('birthdayAt', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'html5'  => false,
                'attr' => ['class'=> 'datepicker'],
            ])
            ->add('location', LocationType::class, [
                'required' => false,
                'label' => false,
                ])

            ->add('avatarFile', FileType::class, [
                'label' => 'Ajouter/modifier votre avatar',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getChoices($choices)
    {
        $output = [];
        foreach($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
