<?php

namespace App\Service;

use App\Exception\FarmCapacityExceededException;
use App\Repository\CowRepository;
use App\Repository\FarmRepository;

class ServiceFarm
{
    private $cowRepository;
    private $farmRepository;

    public function __construct(CowRepository $cowRepository, FarmRepository $farmRepository)
    {
        $this->cowRepository = $cowRepository;
        $this->farmRepository = $farmRepository;
    }

    public function validaCapacidade($farmId)
    {
        $farm = $this->farmRepository->find($farmId);

        if (!$farm) {
            throw new \InvalidArgumentException('Fazenda não encontrada.');
        }
        $numberOfCows = $this->cowRepository->count(['fazenda' => $farm, 'status' => true]); // Numero de bovinos atual na fazenda
        $maxCows = $farm->getTamanho() * 1; // Bovinos por hectares
        if ($numberOfCows >= $maxCows) {
            throw new FarmCapacityExceededException();
        }

        return true;
    }
}
