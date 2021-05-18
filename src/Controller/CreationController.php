<?php

namespace App\Controller;

use App\Repository\CreationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationController extends AbstractController
{
    /**
     * @Route("/creation", name="creation")
     */
    public function index(CreationRepository $creationRepository): Response
    {
        
        return $this->render('creation/index.html.twig', [
            'creations' => $creationRepository->findAll(),
        ]);
    }
}
