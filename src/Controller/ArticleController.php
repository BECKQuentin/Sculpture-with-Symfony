<?php

namespace App\Controller;

use App\Entity\Article;
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
        return $this->render('article/index.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/command-article/{id}", name="command_article")
     */
    public function seeArticle(Article $article): Response
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_MEMBER')) {

            return $this->render('commandArticle.html.twig', [
                'article' => $article
            ]);
        } else {
            $this->addFlash('Warning', 'Veuillez vous inscire');
            return $this->redirectToRoute('app_register');
        }
    }
}
