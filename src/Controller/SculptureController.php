<?php

namespace App\Controller;

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
}
