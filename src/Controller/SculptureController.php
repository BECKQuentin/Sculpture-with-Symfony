<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SculptureController extends AbstractController
{
    /**
     * @Route("/sculpture", name="sculpture")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('shop/sculpture/index.html.twig', [
            'articles' => $articleRepository->findBy(['categorie' => 3])
        ]);
    }

    /**
     * Permet de "liker" ou "unliker" un article    
     * 
     * @route("/article/{id}/like", name="article_like")    
     * 
     * @param Article $article
     * @param ObjectManager $manager
     * @param ArticleLikeRepository $articleLikeRepository
     * @return Response
     */
    public function like(Article $article, ArticleLikeRepository $articleLikeRepository): Response
    {
        $user = $this->getUser();

        if(!$user) return $this->json([
            'code' => 403,
            'message' => "You should be conected"
        ], 403);

        if($article->isLikedByUser($user)) {
            $like = $articleLikeRepository->findOneBy([
                'article' => $article,
                'user' => $user
            ]);

            $em = $this->getDoctrine()->getManager();
            $em->remove($like);
            $em->flush();             
            
            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $articleLikeRepository->count(['article' => $article])
            ], 200);
        }

        $like = new ArticleLike;
        $like->setArticle($article)->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($like);
        $em->flush();   

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $articleLikeRepository->count(['article' => $article])
        ], 200);
    }
}
