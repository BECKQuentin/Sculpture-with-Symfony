<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ImagesHomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(ImagesHomeRepository $imagesHomeRepository, ArticleRepository $articleRepository): Response
    {   
        
        return $this->render('base/home.html.twig', [
            'imagesHome' => $imagesHomeRepository->findAll(),
            'recentsArticles' => $articleRepository->findRecentsArticles(5),
        ]);
    }  
     
    public function header(string $routeName)
    {
        return $this->render('base/_header.html.twig', [            
            'route_name' =>$routeName,
        ]);     
    }

    /**
     * @Route("/redirect-user", name="redirect_user")
     */
    public function redirectUser()
    {
     
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        elseif ($this->isGranted('ROLE_MEMBER')) {
            return $this->redirectToRoute('member');
        }       
        elseif ($this->isGranted('ROLE_UNVERIFIED')) { 
            $this->addFlash('danger', 'Vérifier votre adresse Email pour vous connecter.');           
            return $this->redirectToRoute('app_login');
        }       
        else {
            return $this->redirectToRoute('home');
        }
    }
    
}
