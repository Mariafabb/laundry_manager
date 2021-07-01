<?php

namespace App\Repository;

use App\Entity\OrdiniRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrdiniRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdiniRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdiniRow[]    findAll()
 * @method OrdiniRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdiniRowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdiniRow::class);
    }

    // /**
    //  * @return OrdiniRow[] Returns an array of OrdiniRow objects
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
    public function findOneBySomeField($value): ?OrdiniRow
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
