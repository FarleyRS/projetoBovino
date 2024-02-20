<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class RemoveCommaTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        // Transforma o valor original para seu formato de exibição
        return $value;
    }

    public function reverseTransform($value)
    {
        // Transforma o valor submetido de volta para seu formato original
        if (null === $value) {
            return null;
        }

        return str_replace(',', '', $value);
    }
}
