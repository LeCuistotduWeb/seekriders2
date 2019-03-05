<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['required' => false,])
            ->add('surname', TextType::class, ['required' => false,])
            ->add('username', TextType::class, ['required' => false,])
            ->add('email', EmailType::class, [])
            ->add('level', ChoiceType::class, [
                'choices' => $this->getChoices(User::USER_LEVEL),
            ])

//            ->add('password', PasswordType::class, [
//                'required' => false,
//            ])
//            ->add('passwordConfirm', PasswordType::class, [
//                'required' => false,
//            ])

            ->add('biography', TextareaType::class, ['required' => false,])

            ->add('birthdayAt', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'html5'  => false,
                'attr' => ['class'=> 'datepicker'],
            ])
            ->add('biography', TextareaType::class, ['required' => false,])

            ->add('avatarFile', FileType::class, [
                'label' => 'Ajouter/modifier l\'avatar avatar',
                'required' => false,
            ])
            ->add('location', LocationType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('roles', ChoiceType::class,[
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
//                    'Editeur' => 'ROLE_EDITOR',
//                    'Marketing' => 'ROLE_MARKETING',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'label' => "Role utilisateur"
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
