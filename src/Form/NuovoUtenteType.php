<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NuovoUtenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Le password non coincidono',
            'required' => true,
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Ripetere la Password']
            ])
            ->add('nome')
            ->add('cognome')
            ->add('email', null, [
                'label' => "Mail",
            ])
            ->add('salva', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
