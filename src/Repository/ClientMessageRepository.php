<?php

namespace App\Repository;

use App\Entity\ClientMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientMessage[]    findAll()
 * @method ClientMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientMessage::class);
    }
    
    // /**
    //  * @return ClientMessage[] Returns an array of ClientMessage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClientMessage
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
