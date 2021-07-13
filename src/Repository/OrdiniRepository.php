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

    public function findByLikeFilter($filter)
    {
        return $this->createQueryBuilder('o')
            ->select('o.id, c.nome, c.cognome, o.data_ordine, o.data_consegna, o.note, u.cognome, o.totale')
            ->join('o.cliente', 'c')
            ->join('o.user', 'u')
            ->andWhere('c.nome LIKE :val OR c.cognome like :val1 OR o.id LIKE :val2')
            ->setParameter('val', "$filter%")
            ->setParameter('val1', "$filter%")
            ->setParameter('val2', "$filter%")
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findAllWithLimit(){
        $this->createQueryBuilder('o')
            ->setMaxResults(30);
    }
*/

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
