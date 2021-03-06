<?php

namespace App\Form;

use App\Entity\OrdiniRow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NuovoOrdineRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('capo', CapiSelectTextType::class)
            ->add('ordine', OrdiniSelectTextType::class)
            ->add('data_consegna')
            ->add('importo')
            ->add('salva', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrdiniRow::class,
        ]);
    }
}
