<?php

namespace App\Repository;

use App\Entity\Cow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

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
            ->andWhere('g.status = :status')
            ->setParameter('status', true)
            ->select('SUM(g.qt_leite) as totalLeite')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findQuantidadeTotalRacao()
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.status = :status')
            ->setParameter('status', true)
            ->select('SUM(g.qt_racao) as totalRacao')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findJovensConsumindoMaisRacao()
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.status = :status')
            ->andWhere('DATE_DIFF(CURRENT_DATE(), g.nascimento) / 365 < :idadeLimite')
            ->andWhere('g.qt_racao > :quantidadeRacaoLimite')
            ->setParameter('status', true)
            ->setParameter('idadeLimite', 1)
            ->setParameter('quantidadeRacaoLimite', 500)
            ->getQuery()
            ->getResult();
    }

    public function findGadosParaAbate() : QueryBuilder
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.status = :status')
            ->andWhere('DATE_DIFF(CURRENT_DATE(), g.nascimento) / 365 > :idadeLimite OR g.qt_leite < :litrosLeiteLimite OR (g.qt_leite < :litrosLeiteLimiteAlt AND g.qt_racao / 7 > :quantidadeRacaoLimite) OR g.peso / 15 > :pesoLimite')
            ->setParameter('status', true)
            ->setParameter('idadeLimite', 5)
            ->setParameter('litrosLeiteLimite', 40)
            ->setParameter('litrosLeiteLimiteAlt', 70)
            ->setParameter('quantidadeRacaoLimite', 50)
            ->setParameter('pesoLimite', 18);
    }
}
