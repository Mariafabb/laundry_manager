<?php

namespace App\Repository;

use App\Entity\Impostazioni;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Impostazioni|null find($id, $lockMode = null, $lockVersion = null)
 * @method Impostazioni|null findOneBy(array $criteria, array $orderBy = null)
 * @method Impostazioni[]    findAll()
 * @method Impostazioni[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImpostazioniRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Impostazioni::class);
    }

    // /**
    //  * @return Impostazioni[] Returns an array of Impostazioni objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Impostazioni
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
