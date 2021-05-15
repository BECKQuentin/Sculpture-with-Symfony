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

    // public function findArticlesByCategorie($categorie)
    // {
    //     return $this->findBy();
    // }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */    
    public function findBySearch($search): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :search')
            ->orWhere('a.description LIKE :search')
            ->orWhere('a.prix LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */    
    public function articleSearch(array $params): array
    {
        if (!empty($params['search_articles'])) {
            $search = $params['search_articles'];
            $articles = $this->findBySearch($search);
        } else if (!empty($params['search_select_articles']) && $params['search_select_articles'] == 1) {

            $articles = $this->findBy(array(), array('title' => 'ASC'));
        } else if (!empty($params['search_select_articles']) && $params['search_select_articles'] == 2) {

            $articles = $this->findBy(array(), array('title' => 'DESC'));
        } else if (!empty($params['search_select_articles']) && $params['search_select_articles'] == 3) {

            $articles = $this->findBy(array(), array('prix' => 'ASC'));
        } else if (!empty($params['search_select_articles']) && $params['search_select_articles'] == 4) {

            $articles = $this->findBy(array(), array('prix' => 'DESC'));
        } else if (!empty($params['search_select_articles']) && $params['search_select_articles'] == 5) {

            $articles = $this->findBy(array(), array('categorie'::class => 'ASC'));
        } else {
            $articles = $this->findAll();
        }
        return $articles;
    }


    // // /**
    // //  * @return Playlist[] Returns an array of Playlist objects
    // //  */
    // public function findAllPlaylists($user)
    // {
    //     return $this->createQueryBuilder('playlist')
    //         ->leftJoin('playlist.id_user', 'playlist_id_user')
    //         ->andWhere('playlist_id_user.id = :user')
    //         ->setParameter('user', $user)
    //         ->orderBy('playlist.title', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

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
