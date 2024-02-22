<?php

namespace App\Form;

use App\Entity\Cow;
use App\Entity\Farm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo', NumberType::class, [
                'label' => 'Codigo'
            ])
            ->add('qt_leite', NumberType::class, [
                'scale' => 2,
                'label' => 'Quantidade Leite'
            ])
            ->add('qt_racao', NumberType::class, [
                'scale' => 2,
                'label' => 'Quantidade Ração'
            ])
            ->add('peso', NumberType::class, [
                'scale' => 2,
            ])
            ->add('nascimento', DateType::class, [
                'label' => 'Data de Nascinemto'
            ])
            ->add('fazenda', EntityType::class,[
                'class' => Farm::class,
                'label' => 'Fazenda pertencente'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cow::class,
        ]);
    }
}
