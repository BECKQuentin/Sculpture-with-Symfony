<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BougeoirController extends AbstractController
{
    /**
     * @Route("/bougeoir", name="bougeoir")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('boutique/bougeoir/index.html.twig', [
            'articles' => $articleRepository->findBy(['categorie' => 1])
        ]);
    }
    
            
    
}
