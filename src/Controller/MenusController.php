<?php

namespace App\Controller;

use App\Entity\ImagesHome;
use App\Form\ImagesHomeFormType;
use App\Repository\ImagesHomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MenusController extends AbstractController
{
    /**
     * @Route("/menus", name="menus")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function index(): Response
    {
        return $this->render('menus/index.html.twig', [
            'controller_name' => 'MenusController',
        ]);
    }

     /**
     * @Route("/images-home", name="images_home")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function imagesHome(ImagesHomeRepository $imagesHomeRepository, Request $request)
    {
        
        $form = $this->createForm(ImagesHomeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $images = $form->get('name')->getData();
            dd($images);

            foreach ($images as $img) {

                $img = new ImagesHome();

                $em = $this->getDoctrine()->getManager();
                $em->persist($img);
                $em->flush();
            }

            
            $this->addFlash('success', "Ajoutée avec succès'");
            return $this->redirectToRoute('images_home');
        }

        return $this->render('menus/images_home.html.twig', [
            'form' => $form->createView(),
            'imagesHome' => $imagesHomeRepository->findAll(),
        ]);
    }
    
}
