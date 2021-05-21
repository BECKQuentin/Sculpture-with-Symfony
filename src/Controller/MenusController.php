<?php

namespace App\Controller;

use App\Entity\ImagesHome;
use App\Form\ImagesHomeFormType;
use App\Repository\ImagesHomeRepository;
use App\Service\UploadService;
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
    public function imagesHome(ImagesHomeRepository $imagesHomeRepository, UploadService $uploadService, Request $request)
    {
        $image = new ImagesHome();
        $form = $this->createForm(ImagesHomeFormType::class, $image);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {            
            
            $images = $form->get('image')->getData();            

            if($images) {
                foreach ($images as $img) {

                    $fileName = $uploadService->uploadImagesHome($img); 
                    $img = new ImagesHome();                    
                    $img->setImage($fileName);  
    
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($img);
                    $em->flush();
                }            
            }  
            else {
                $this->addFlash('danger', 'Ajouter une ou plusieurs images !');
            }          
            
            $this->addFlash('success', "Ajout réalisé avec succès'");
            return $this->redirectToRoute('images_home');
        }        

        return $this->render('menus/images_home.html.twig', [
            'form' => $form->createView(),
            'imagesHome' => $imagesHomeRepository->findAll(),
        ]);
    }


    /**
    * @Route("/delete-imagesHome/{id}", name="delete_imagesHome")
    * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
    */
    public function deleteImagesHome(ImagesHome $imagesHome): Response
    {
        // dd($imagesHome);
        $em = $this->getDoctrine()->getManager();
        $em->remove($imagesHome);
        $em->flush();  

        $this->addFlash('danger', "Vous avez supprimé une image !");
        return $this->redirectToRoute('images_home');       
      
    }
   
    
    
}
