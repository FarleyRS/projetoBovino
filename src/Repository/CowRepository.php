<?php

namespace App\Repository;

use App\Entity\Cow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cow>
 *
 * @method Cow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cow[]    findAll()
 * @method Cow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cow::class);
    }

    public function add(Cow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findQuantidadeTotalLeite()
    {
        return $this->createQueryBuilder('g')
            ->select('SUM(g.qt_leite) as totalLeite')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findQuantidadeTotalRacao()
    {
        return $this->createQueryBuilder('g')
            ->select('SUM(g.qt_racao) as totalRacao')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
