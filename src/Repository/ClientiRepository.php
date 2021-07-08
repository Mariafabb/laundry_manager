<?php

namespace App\Repository;

use App\Entity\Clienti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Clienti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clienti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clienti[]    findAll()
 * @method Clienti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clienti::class);
    }

    public function findByLikeFilter($filter)
    {
        return $this->createQueryBuilder('c')
            ->select('CONCAT(c.nome, \' \', c.cognome) as nome_cognome', 'c.id', 'c.nome', 'c.cognome')
            ->andWhere('c.nome LIKE :val OR c.cognome LIKE :val1')
            ->setParameter('val', "$filter%")
            ->setParameter('val1', "$filter%")
            ->orderBy('c.cognome', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}
