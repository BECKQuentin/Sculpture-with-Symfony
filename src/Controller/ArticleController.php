<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="article")
     */
    public function index(Article $article): Response
    {
        
        return $this->render('article/article.html.twig', [
            'article' => $article,
            'user' => $this->getUser()
        ]);
    }
}
