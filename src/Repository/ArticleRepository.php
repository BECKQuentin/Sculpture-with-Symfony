<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }    

    public function findRecentArticles(int $limit = null)
    {
        return $this->findBy([], ['id' => 'DESC'], $limit);
    }    
    public function findBlogArticles()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery();
    }
    public function findArticlesByCategorie($categorie)
    {
        return $this->findBy();
    }



    public function findAllBougeoirs() 
    {        
        return $this->createQueryBuilder('b')
                    ->andWhere('b.categorie = 1')          
                    ->getQuery()
                    ->getResult()
        ;
    }
    public function findAllLampe() 
    {        
        return $this->createQueryBuilder('b')
                    ->andWhere('b.categorie = 2')          
                    ->getQuery()
                    ->getResult()
        ;
    }
    public function findAllSculpture() 
    {        
        return $this->createQueryBuilder('b')
                    ->andWhere('b.categorie = 3')          
                    ->getQuery()
                    ->getResult()
        ;
    }
    

    

    // /**
    //  * @return Article[] Returns an array of Article objects
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
    public function findOneBySomeField($value): ?Article
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
