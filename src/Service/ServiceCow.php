<?php

namespace App\Service;

use App\Repository\CowRepository;

class ServiceCow
{
    private $cowRepository;

    public function __construct(CowRepository $cowRepository)
    {
        $this->cowRepository = $cowRepository;
    }

    public function validaCodigo($codigo)
    {
        // Verifica se já existe um animal vivo com o mesmo código.
        $existingAnimal = $this->cowRepository->findOneBy(['codigo' => $codigo, 'status' => true]);

        if ($existingAnimal !== null) {
            throw new \InvalidArgumentException('Já existe um animal vivo com o mesmo código.');
        }

        return true;
    }
}
