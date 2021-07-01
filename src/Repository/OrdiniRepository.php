<?php

namespace App\Repository;

use App\Entity\Ordini;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ordini|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordini|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordini[]    findAll()
 * @method Ordini[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdiniRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordini::class);
    }

    // /**
    //  * @return Ordini[] Returns an array of Ordini objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ordini
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
