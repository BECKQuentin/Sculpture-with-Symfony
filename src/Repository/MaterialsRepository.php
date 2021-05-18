<?php

namespace App\Repository;

use App\Entity\Materials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Materials|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materials|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materials[]    findAll()
 * @method Materials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materials::class);
    }

    // /**
    //  * @return Materials[] Returns an array of Materials objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Materials
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
