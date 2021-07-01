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

    // /**
    //  * @return ACapi[] Returns an array of ACapi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ACapi
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
