<?php

namespace App\Repository;

use App\Entity\Farm;
use App\Entity\Veterinarian;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Veterinarian>
 *
 * @method Veterinarian|null find($id, $lockMode = null, $lockVersion = null)
 * @method Veterinarian|null findOneBy(array $criteria, array $orderBy = null)
 * @method Veterinarian[]    findAll()
 * @method Veterinarian[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VeterinarianRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Veterinarian::class);
    }

    public function add(Veterinarian $entity, bool $flush = false): void
    {    
        $this->getEntityManager()->persist($entity);
    
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function remove(Veterinarian $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
