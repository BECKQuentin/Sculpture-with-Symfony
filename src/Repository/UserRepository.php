<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findAllMembers(User $user): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.emailVerified LIKE :email_verified')
            ->andWhere('u.id != :user')
            ->setParameter('email_verified', 1)            
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySearch(User $user, $search): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.emailVerified LIKE :email_verified')
            ->andWhere('u.id != :user')
            ->andWhere('u.name = :search')
            ->setParameter('email_verified', 1)            
            ->setParameter('user', $user)
            ->setParameter('search', $search)            
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySelectDesc(User $user): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.emailVerified LIKE :email_verified')
            ->andWhere('u.id != :user')
            ->orderBy('u.email', 'DESC')
            ->setParameter('email_verified', 1)            
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySelectAsc(User $user): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.emailVerified LIKE :email_verified')
            ->andWhere('u.id != :user')
            ->orderBy('u.email', 'ASC')
            ->setParameter('email_verified', 1)            
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function userSearch(User $user, array $params): array
    {
        if(!empty($params['search'])) {
            $search = $params['search']; 
            $members = $this->findBySearch($user, $search);            
        }
        else if (!empty($params['search_select']) && $params['search_select'] == 1) {
           
            $members = $this->findBySelectAsc($user);
        }
        else if (!empty($params['search_select']) && $params['search_select'] == 2) {
            
            $members = $this->findBySelectDesc($user);            
        }
        else {
            $members = $this->findAllMembers($user);
        }       
        return $members; 
    }

    // // /**
    // //  * @return Articles[] Returns an array of Articles objects
    // //  */
    // public function findAllArticles($user)
    // {
    //     return $this->createQueryBuilder('user_article')
    //         ->from('App\Entity\Article', 'u_a')            
    //         ->andWhere('u_a.id = :user')            
    //         ->setParameter('user', $user)
    //         ->orderBy('u_a.title', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }




    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
