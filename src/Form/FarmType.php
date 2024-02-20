<?php

namespace App\Form;

use App\Entity\Farm;
use App\Entity\Veterinarian;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FarmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome')
            ->add('tamanho', NumberType::class, [
                'scale' => 2,
            ])
            ->add('responsavel')
            ->add(
                'veterinarios',
                EntityType::class,
                [
                    'class' => Veterinarian::class,
                    'multiple' => true,
                    'expanded' => true
                ]

            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Farm::class,
        ]);
    }
}
