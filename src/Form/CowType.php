<?php

namespace App\Form;

use App\Entity\Cow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo')
            ->add('qt_leite')
            ->add('qt_racao')
            ->add('peso')
            ->add('nascimento')
            ->add('fazenda')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cow::class,
        ]);
    }
}
