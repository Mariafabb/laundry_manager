<?php

namespace App\Form;

use App\Entity\Impostazioni;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Config\TwigExtra\StringConfig;

class ImpostazioniType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("logo", null, [
              'mapped' => false,
            ])
            ->add("metodo_calcolo_consegna", ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    '' => null,
                    'Statico' => 0,
                    'Dinamico' => 1,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Impostazioni::class,
        ]);
    }
}
