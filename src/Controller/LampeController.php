<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LampeController extends AbstractController
{
    /**
     * @Route("/lampe", name="lampe")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('boutique/lampe/index.html.twig', [
            'articles' => $articleRepository->findBy(['categorie' => 2])
        ]);
    }
}
