<?php

namespace App\Form;

use App\Entity\Cow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo')
            ->add('qt_leite', NumberType::class, [
                'scale' => 2,
            ])
            ->add('qt_racao', NumberType::class, [
                'scale' => 2,
            ])
            ->add('peso', NumberType::class, [
                'scale' => 2,
            ])
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
