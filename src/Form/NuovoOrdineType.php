<?php

namespace App\Form;

use App\Entity\Ordini;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('user', UserSelectTextType::class)
            ->add('data_ordine', DateType::class)
            ->add('data_consegna',DateType::class)
            ->add('totale',NumberType::class)
            ->add('note',TextType::class)

            ->add('aggiungi_capo', ButtonType::class, [

            ])
            ->add('elimina_capo', ButtonType::class, [

            ])

            ->add('nuovo_capo', CapiSelectTextType::class, [
                'mapped' => false
            ])

            ->add('capi', CollectionType::class, [
                'mapped' => false
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
