<?php

namespace App\Form;

use App\Entity\Ordini;
use App\Entity\OrdiniRow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NuovoOrdineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cliente', ClientiSelectTextType::class)
            ->add('cliente_id', HiddenType::class, [
                'mapped' => false,
            ])
//            ->add('user', UserSelectTextType::class)
            ->add('data_ordine', DateType::class)
            ->add('data_consegna',DateType::class)
            ->add('totale',NumberType::class, [
                'attr' => [
                    'readonly' => true,
                    ],
                ])
            ->add('note',TextType::class, [
                'required' => false,
            ])
            ->add('nuovo_capo', TextType::class, [
                'mapped' => false
            ])
            ->add('numero_capi', IntegerType::class, [
                'mapped' =>false,
            ])
            ->add('nuovo_capo_id', IntegerType::class, [
                'mapped' => false
            ])

            ->add('ordiniRows', CollectionType::class, [
                'mapped' => false,
                'entry_type' => NuovoOrdineRowType::class,
                'allow_add' => true,
                'prototype' => false,
            ])

            ->add('salva', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ordini::class,
        ]);
    }
}
