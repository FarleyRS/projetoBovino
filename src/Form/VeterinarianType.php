<?php

namespace App\Form;

use App\Entity\Farm;
use App\Entity\Veterinarian;
use App\Form\DataTransformer\RemoveCommaTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeterinarianType extends AbstractType
{
    private $transformer;

    public function __construct(RemoveCommaTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome', TextType::class,[
                'label' => 'Nome'
            ])
            ->add('CRMV', TextType::class,[
                'label' => 'CRMV'
            ])
            ->add(
                'farms',
                EntityType::class,
                [
                    'class' => Farm::class,
                    'multiple' => true,
                    'label' => 'Fazendas',
                    'attr' => [
                        'class' => 'select-farms',
                        'label' => 'Fazendas',
                    ]
                ]
            );

        $builder->get('CRMV')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Veterinarian::class,
        ]);
    }
}
