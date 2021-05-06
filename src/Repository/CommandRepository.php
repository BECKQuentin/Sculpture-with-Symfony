<?php

namespace App\Repository;

use App\Entity\Command;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Command|null find($id, $lockMode = null, $lockVersion = null)
 * @method Command|null findOneBy(array $criteria, array $orderBy = null)
 * @method Command[]    findAll()
 * @method Command[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Command::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */    
    // public function findBySearch($search): array
    // {
    //     return $this->createQueryBuilder('c') 
    //         ->Where('c.Article.title LIKE :search')
    //         ->orWhere('c.Article.description LIKE :search')
    //         ->orWhere('c.Article.prix LIKE :search')
    //         ->orWhere('c.User.name LIKE :search')
    //         ->orWhere('c.User.lastname LIKE :search')
    //         ->orWhere('c.User.adress LIKE :search')
    //         ->setParameter('search', '%'.$search.'%')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // } 
    
    // /**
    //  * @return Commands[] Returns an array of Commands objects
    //  */    
    // public function commandSearch(array $params): array
    // {
    //     if(!empty($params['search_commands'])) {
    //         $search = $params['search_commands']; 
    //         $articles = $this->findBySearch($search);            
    //     }
    //     else if (!empty($params['search_select_commands']) && $params['search_select_commands'] == 1) {
           
    //         $articles = $this->findBy(array(), array('title' => 'ASC'));
    //     }
    //     else if (!empty($params['search_select_commands']) && $params['search_select_commands'] == 2) {
            
    //         $articles = $this->findBy(array(), array('title' => 'DESC'));        
    //     }
    //     else if (!empty($params['search_select_commands']) && $params['search_select_commands'] == 3) {
            
    //         $articles = $this->findBy(array(), array('prix' => 'ASC'));            
    //     }
    //     else if (!empty($params['search_select_commands']) && $params['search_select_commands'] == 4) {
            
    //         $articles = $this->findBy(array(), array('prix' => 'DESC'));            
    //     }
    //     else if (!empty($params['search_select_commands']) && $params['search_select_commands'] == 5) {
            
    //         $articles = $this->findBy(array(), array('categorie'::class => 'ASC'));            
    //     }
    //     else {
    //         $articles = $this->findAll();
    //     }       
    //     return $articles; 
    // }

    /*
    public function findOneBySomeField($value): ?Command
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
