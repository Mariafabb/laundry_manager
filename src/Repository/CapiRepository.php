<?php

namespace App\Repository;

use App\Entity\Capi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Capi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capi[]    findAll()
 * @method Capi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Capi::class);
    }

    public function findByLikeFilter($filter)
    {
        return $this->createQueryBuilder('c')
            ->select('c.tipo', 'c.id')
            ->andWhere('c.tipo LIKE :val')
            ->setParameter('val', "$filter%")
            ->orderBy('c.tipo', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}