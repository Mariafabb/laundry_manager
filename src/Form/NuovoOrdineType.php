<?php

namespace App\Form;

use App\Entity\Ordini;
use App\Entity\OrdiniRow;
use phpDocumentor\Reflection\Type;
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
        $readOnly = $options['edit'] === true ? true : false;

        $builder
            ->add('cliente', ClientiSelectTextType::class,[
            'required' => false,
                'attr' => [
                    'readonly' => $readOnly
                ]
            ])
            ->add('cliente_id', HiddenType::class, [
                'mapped' => false,
            ])
//            ->add('user', UserSelectTextType::class)
            ->add('totale',NumberType::class, [

                ])
            ->add('note',TextType::class, [
                'required' => false,
            ])
            ->add('nuovo_capo', TextType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('numero_capi', IntegerType::class, [
                'mapped' =>false,
                'label' => "N. Capi",
                'required' => false,
            ])
            ->add('nuovo_capo_id', HiddenType::class, [
                'mapped' => false,
                'required' => false,
            ])

            ->add('ordiniRows', CollectionType::class, [
                'mapped' => false,
                'entry_type' => NuovoOrdineRowType::class,
                'allow_add' => true,
                'prototype' => false,
                'label' => false
            ])

            ->add('salva', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ordini::class,
            'edit' => false,
        ]);
    }
}
