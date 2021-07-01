<?php

namespace App\Form;

use App\Entity\Clienti;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type;

class NuovoClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('cognome')
            ->add('indirizzo')
            ->add('cap')
            ->add('comune')
            ->add('provincia')
            ->add('stato')
            ->add('telefono')
            ->add('cellulare')
            ->add('email')
            ->add('codice_fiscale')
            ->add('p_iva')
            ->add('codice_univoco')
            ->add('pec')
            ->add('salva', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clienti::class,
        ]);
    }
}
