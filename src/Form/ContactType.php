<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[])
            ->add('object', TextType::class,[])
            ->add('email', EmailType::class,[])
            ->add('message', TextareaType::class,[])
            ->add('rgpd', CheckboxType::class, [
                'label'    => 'En soumettant ce formulaire, j\'accepte que les informations saisies dans ce formulaire soient utilisées, pour permettre de
                    vous recontacter.',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Contact::class,
        ]);
    }
}
