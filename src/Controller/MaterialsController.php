<?php

namespace App\Controller;

use App\Entity\Materials;
use App\Form\MaterialsFormType;
use App\Repository\MaterialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MaterialsController extends AbstractController
{
     /**
     * @Route("/materials-listing", name="materials_listing")
     * @IsGranted("ROLE_ADMIN", message="Seuls les ADMINS peuvent faire ça")
     */
    public function addMaterial(MaterialsRepository $materialsRepository, Request $request)
    {
        $material = new Materials();
        $form = $this->createForm(MaterialsFormType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($material);
            $em->flush();

            $this->addFlash('success', "Le materiaux a bien été ajouté");
            return $this->redirectToRoute('materials_listing');
        }

        return $this->render('listing/materials.html.twig', [
            'form' => $form->createView(),
            'materials' => $materialsRepository->findAll(),
        ]);
    }
    /**
    * @Route("/delete-material/{id}", name="delete_material")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function deleteArticle(Materials $material): Response
    {        
        $em = $this->getDoctrine()->getManager();        
        $em->remove($material);
        $em->flush();        
        
        $this->addFlash('danger', "Vous avez supprimé ".$material->getName()."  !");
        return $this->redirectToRoute('materials_listing');
    }

    /**
    * @Route("/update-material/{id}", name="update_material")
    * @IsGranted("ROLE_ADMIN", message="Seules les ADMINS peuvent faire ça")
    */
    public function memberUpdate(Materials $material, MaterialsRepository $materialsRepository, Request $request)
    {     
        $form = $this->createForm(MaterialsFormType::class, $material);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($material);
            $em->flush();

            $this->addFlash('success', "Les modifications ont bien été sauvegardées !");
            return $this->redirectToRoute('materials_listing');
        }

        return $this->render('listing/materials.html.twig', [
            'form' => $form->createView(),
            'materials' => $materialsRepository->findAll()
        ]);
    } 
}
