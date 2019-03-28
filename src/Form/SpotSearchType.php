<?php

namespace App\Form;

use App\Entity\Spot;
use App\Entity\SpotSearch;
use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpotSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'nom du spot',
                'attr' => ['placeholder' => 'nom du spot'],
            ])
            ->add('type', ChoiceType::class, [
                'required' => false,
                'choices' => $this->getChoices(Spot::SPOT_TYPE),
            ])
            ->add('distance', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    '5 km' => 5,
                    '10 km' => 10,
                    '25 km' => 25,
                    '50 km' => 50,
                    '100 km' => 100,
                ]
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('address', TextType::class, [
                'required' => false,
                'attr' => ['id' => "search_address"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SpotSearch::class,
            'method' => 'POST',
            'csrf_protection' => false,
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
