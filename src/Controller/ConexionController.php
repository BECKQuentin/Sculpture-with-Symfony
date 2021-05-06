<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConexionController extends AbstractController
{
    /**
     * @Route("/conexion", name="conexion")
     */
    public function index(): Response
    {
        return $this->render('conexion/index.html.twig', [
            'controller_name' => 'ConexionController',
        ]);
    }
}
