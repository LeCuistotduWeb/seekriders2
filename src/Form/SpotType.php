<?php

namespace App\Form;

use App\Entity\Spot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => $this->getChoices(Spot::SPOT_TYPE),
            ])
            ->add('paying', ChoiceType::class, [
                'choices' => $this->getChoices(Spot::PRICE),
                'label' => 'Prix',
            ])
            ->add('location', LocationType::class, [
                'label' => false,
            ])
            ->add('picturesFiles', FileType::class, [
                'required' => false,
                'multiple' => true,
                'label' => 'Ajouter des photos',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
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
