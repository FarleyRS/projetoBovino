<?php

namespace App\Form;

use App\Entity\Farm;
use App\Entity\Veterinarian;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('nome', TextType::class,[
                'label' => 'Nome'
            ])
            ->add('tamanho', NumberType::class, [
                'scale' => 2,
                'label' => 'Tamanho'
            ])
            ->add('responsavel', TextType::class,[
                'label' => 'Nome do responsável'
            ])
            ->add(
                'veterinarios',
                EntityType::class,
                [
                    'class' => Veterinarian::class,
                    'multiple' => true,
                    'label' => 'Veterinarios',
                    'attr' => [
                        'class' => 'select-vet',
                        'label' => 'Veterinarios',
                    ]
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
